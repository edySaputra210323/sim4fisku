<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaran = [
            [
                'th_ajaran' => '2021/2022',
                'periode_mulai' => '2021-08-01',
                'periode_akhir' => '2022-06-30',
                'status' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'th_ajaran' => '2022/2023',
                'periode_mulai' => '2022-08-01',
                'periode_akhir' => '2023-06-30',
                'status' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'th_ajaran' => '2023/2024',
                'periode_mulai' => '2023-08-01',
                'periode_akhir' => '2024-06-30',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'th_ajaran' => '2024/2025',
                'periode_mulai' => null, // Nullable, jadi boleh kosong
                'periode_akhir' => null,
                'status' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($tahunAjaran as $tahun) {
            TahunAjaran::create($tahun);
        }
    }
}
