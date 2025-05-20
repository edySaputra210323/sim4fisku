<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluar';

    protected $fillable = [

        'no_surat',
        'kategori_surat_id',
        'tgl_surat_keluar',
        'perihal',
        'tujuan_pengiriman',
        'deskripsi', 
        'dokumen',
        'dibuat_oleh_id', 
        'smester_id',
        'th_ajaran_id',
        'nomor_urut',
    ];

    public function kategoriSurat()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_surat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'th_ajaran_id');
    }

    public function smester()
    {
        return $this->belongsTo(Semester::class, 'smester_id');
    }
}
