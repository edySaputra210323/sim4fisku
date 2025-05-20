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
        Schema::create('smester', function (Blueprint $table) {
            $table->id();
            $table->foreignId('th_ajaran_id')->nullable()->constrained('tahun_ajaran')->nullOnDelete();
            $table->string('nm_smester',10);
            $table->date('periode_mulai')->nullable();
            $table->date('periode_akhir')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smester');
    }
};
