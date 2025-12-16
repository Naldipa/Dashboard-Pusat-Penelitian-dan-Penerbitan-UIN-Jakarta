<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Penelitian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User dummy
        User::factory()->create([
            'name' => 'Nasya Rohmatunisa',
            'email' => 'nasya@gmail.com',
            'password'=> bcrypt('nasya123'),
        ]);

        // Dummy data Penelitian
        Penelitian::insert([
            [
                'judul' => 'Pengembangan Metode Pembelajaran Aktif di Kelas',
                'fakultas' => 'Fakultas Ilmu Tarbiyah dan Keguruan',
                'penulis_utama' => 'Ahmad Fulan',
                'anggota_penulis' => 'Siti Aminah; Budi Santoso',
                'tahun' => 2021,
                'status' => 'Selesai',
                'abstrak' => 'Penelitian tentang penerapan metode pembelajaran aktif...',
                'file_path' => null,
            ],
            [
                'judul' => 'Kajian Naskah Klasik Arab di Indonesia',
                'fakultas' => 'Fakultas Adab dan Humaniora',
                'penulis_utama' => 'Nur Aisyah',
                'anggota_penulis' => 'Muhammad Ali',
                'tahun' => 2022,
                'status' => 'Selesai',
                'abstrak' => 'Analisis filologis terhadap naskah klasik...',
                'file_path' => null,
            ],
            [
                'judul' => 'Digitalisasi Kurikulum Pendidikan Islam',
                'fakultas' => 'Fakultas Ilmu Tarbiyah dan Keguruan',
                'penulis_utama' => 'Rizki Pratama',
                'anggota_penulis' => null,
                'tahun' => 2023,
                'status' => 'Proses',
                'abstrak' => 'Studi pengembangan kurikulum digital...',
                'file_path' => null,
            ],
            [
                'judul' => 'Studi Komparatif Sastra Timur Tengah',
                'fakultas' => 'Fakultas Adab dan Humaniora',
                'penulis_utama' => 'Laila Hasanah',
                'anggota_penulis' => 'Farid Rahman',
                'tahun' => 2024,
                'status' => 'Selesai',
                'abstrak' => 'Perbandingan tema-tema utama dalam sastra Timur Tengah...',
                'file_path' => null,
            ],
            [
                'judul' => 'Model Penguatan Moderasi Beragama di Kampus',
                'fakultas' => 'Fakultas Lainnya',
                'penulis_utama' => 'Slamet Hidayat',
                'anggota_penulis' => 'Ani Lestari',
                'tahun' => 2025,
                'status' => 'Perencanaan',
                'abstrak' => 'Penelitian terkait penguatan moderasi beragama...',
                'file_path' => null,
            ],
        ]);
    }
}
