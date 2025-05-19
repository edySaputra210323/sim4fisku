<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSurat extends Model
{
    protected $table = 'kategori_surat';

    protected $fillable = [
        'kode_kategori',
        'kategori',
        'deskripsi',
    ];
}
