<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fakultas; // PENTING: Import model Fakultas
use App\Models\Penelitian;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Nasya Rohmatunisa',
            'email' => 'nasya@gmail.com',
            'password' => bcrypt('nasya123'),
        ]);

        $fitk = Fakultas::create([
            'nama' => 'Fakultas Ilmu Tarbiyah dan Keguruan',
            'kode' => 'FITK',
        ]);

        $fah = Fakultas::create([
            'nama' => 'Fakultas Adab dan Humaniora',
            'kode' => 'FAH',
        ]);

        $lainnya = Fakultas::create([
            'nama' => 'Fakultas Lainnya',
            'kode' => 'LAIN',
        ]);

        $daftarPenelitian = [
            [
                'judul' => 'Pengembangan Metode Pembelajaran Aktif di Kelas',
                'fakultas_id' => $fitk->id, // Gunakan ID dari variabel di atas
                'fakultas' => $fitk->nama,
                'penulis_utama' => 'Ahmad Fulan',
                'anggota_penulis' => 'Siti Aminah; Budi Santoso',
                'tahun' => 2021,
                'status' => 'Selesai',
                'abstrak' => 'Penelitian tentang penerapan metode pembelajaran aktif...',
            ],
            [
                'judul' => 'Kajian Naskah Klasik Arab di Indonesia',
                'fakultas_id' => $fah->id,
                'fakultas' => $fah->nama,
                'penulis_utama' => 'Nur Aisyah',
                'anggota_penulis' => 'Muhammad Ali',
                'tahun' => 2022,
                'status' => 'Selesai',
                'abstrak' => 'Analisis filologis terhadap naskah klasik...',
            ],
            [
                'judul' => 'Digitalisasi Kurikulum Pendidikan Islam',
                'fakultas_id' => $fitk->id,
                'fakultas' => $fitk->nama,
                'penulis_utama' => 'Rizki Pratama',
                'anggota_penulis' => null,
                'tahun' => 2023,
                'status' => 'Proses',
                'abstrak' => 'Studi pengembangan kurikulum digital...',
            ],
            [
                'judul' => 'Studi Komparatif Sastra Timur Tengah',
                'fakultas_id' => $fah->id,
                'fakultas' => $fah->nama,
                'penulis_utama' => 'Laila Hasanah',
                'anggota_penulis' => 'Farid Rahman',
                'tahun' => 2024,
                'status' => 'Selesai',
                'abstrak' => 'Perbandingan tema-tema utama dalam sastra Timur Tengah...',
            ],
        ];

        // 4. Masukkan Data ke Database
        foreach ($daftarPenelitian as $data) {
            Penelitian::create($data);
        }
    }
}
