<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('nomor_urut')->nullable();
            $table->string('no_surat', 50)->nullable();
            $table->foreignId('kategori_surat_id')->nullable()->constrained('kategori_surat')->nullOnDelete();
            $table->date('tgl_surat_keluar')->nullable();
            $table->string('perihal', 255)->nullable();
            $table->string('tujuan_pengiriman', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('dokumen')->nullable();
            $table->foreignId('dibuat_oleh_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('th_ajaran_id')->nullable()->constrained('tahun_ajaran')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
