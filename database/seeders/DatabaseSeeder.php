<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fakultas;
use App\Models\TahunPenelitian;
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

        $years = [
            ['tahun' => '2021', 'isActive' => 1],
            ['tahun' => '2022', 'isActive' => 0],
            ['tahun' => '2023', 'isActive' => 0],
            ['tahun' => '2024', 'isActive' => 0],
            ['tahun' => '2025', 'isActive' => 0],
        ];

        foreach ($years as $year) {
            TahunPenelitian::create($year);
        }

        $fakultasData = [
            ['nama' => 'Fakultas Ilmu Tarbiyah dan Keguruan', 'kode' => 'FITK' ],
            ['nama' => 'Fakultas Adab dan Humaniora', 'kode' => 'FAH'],
            ['nama' => 'Fakultas Ushuludin', 'kode' => 'FU'],
            ['nama' => 'Fakultas Syariah dan Hukum', 'kode' => 'FSH'],
            ['nama' => 'Fakultas Ilmu Dakwah dan Komunikasi', 'kode' => 'FIDK'],
            ['nama' => 'Fakultas Dirasat Islamiyah', 'kode' => 'FDI'],
            ['nama' => 'Fakultas Psikologi', 'kode' => 'Psikologi'],
            ['nama' => 'Fakultas Ekonomi dan Bisnis', 'kode' => 'FEB'],
            ['nama' => 'Fakultas Sains dan Teknologi', 'kode' => 'FST'],
            ['nama' => 'Fakultas Ilmu Kesehatan', 'kode' => 'FIKES'],
            ['nama' => 'Fakultas Kedokteran', 'kode' => 'FK'],
            ['nama' => 'Fakultas Ilmu Sosial dan Ilmu Politik', 'kode' => 'FISIP'],
            ['nama' => 'Sekolah Pasca Sarjana', 'kode' => 'SPS'],
            ['nama' => 'Unit Lain', 'kode' => 'LAIN'],
        ];

        foreach ($fakultasData as $fakultas) {
            Fakultas::create($fakultas);
        }
    }
}
