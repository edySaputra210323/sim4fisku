<?php

namespace App\Models;

use App\Models\SuratKeluar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'th_ajaran',
        'status',
    ];

    protected static function booted()
    {
        // Listener untuk menghapus cache saat status diubah
        static::updating(function ($tahunAjaran) {
            if ($tahunAjaran->isDirty('status')) {
                cache()->forget('active_tahun_ajaran');
                \Log::info('Cache active_tahun_ajaran dihapus karena status tahun ajaran berubah', [
                    'tahun_ajaran_id' => $tahunAjaran->id,
                    'th_ajaran' => $tahunAjaran->th_ajaran,
                    'status_baru' => $tahunAjaran->status,
                ]);
            }
        });

        // Listener untuk memastikan hanya satu tahun ajaran yang aktif
        static::saving(function ($tahunAjaran) {
            if ($tahunAjaran->status) {
                TahunAjaran::where('id', '!=', $tahunAjaran->id)
                    ->where('status', true)
                    ->update(['status' => false]);
            }
        });
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class, 'th_ajaran_id');
    }

    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'th_ajaran_id');
    }
}
