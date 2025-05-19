<?php

namespace App\Filament\Admin\Resources\SuratKeluarResource\Pages;

use App\Filament\Admin\Resources\SuratKeluarResource;
use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateSuratKeluar extends CreateRecord
{
    protected static string $resource = SuratKeluarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Mengambil tahun ajaran yang aktif
        $activeTahunAjaran = cache()->remember('active_tahun_ajaran', now()->addMinutes(1), fn () => \App\Models\TahunAjaran::where('status', true)->first());
        if (!$activeTahunAjaran) {
            Notification::make()
                ->title('Error')
                ->body('Tidak ada tahun ajaran yang aktif. Silakan aktifkan tahun ajaran terlebih dahulu.')
                ->danger()
                ->send();

            throw new \Exception('Tidak ada tahun ajaran yang aktif. Silakan aktifkan tahun ajaran terlebih dahulu.');
        }

        // Menambahkan ID user yang sedang login ke field 'dibuat_oleh'
        $data['dibuat_oleh'] = auth()->id();
        $data['th_ajaran_id'] = $activeTahunAjaran->id;

        // Generate nomor_urut dan no_surat
        if ($data['tgl_surat_keluar'] && $data['kategori_surat_id']) {
            // Hitung nomor urut berdasarkan th_ajaran_id
            $lastSurat = SuratKeluar::where('th_ajaran_id', $activeTahunAjaran->id)
                ->orderBy('nomor_urut', 'desc')
                ->first();

            $nomorUrut = $lastSurat ? $lastSurat->nomor_urut + 1 : 1;
            $data['nomor_urut'] = $nomorUrut;

            // Gunakan helper dari SuratKeluarResource
            $data['no_surat'] = SuratKeluarResource::generateNomorSurat($data['tgl_surat_keluar'], $data['kategori_surat_id']);

            \Log::info('SuratKeluar berhasil dibuat', [
                'no_surat' => $data['no_surat'],
                'nomor_urut' => $data['nomor_urut'],
                'th_ajaran_id' => $data['th_ajaran_id'],
            ]);
        } else {
            \Log::info('Gagal simpan nomor surat: tgl_surat_keluar atau kategori_surat_id kosong', [
                'tgl_surat_keluar' => $data['tgl_surat_keluar'] ?? null,
                'kategori_surat_id' => $data['kategori_surat_id'] ?? null,
            ]);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        Notification::make()
            ->title('Sukses')
            ->body('Surat keluar berhasil dibuat!')
            ->success()
            ->send();

        return $this->getResource()::getUrl('index');
    }
}