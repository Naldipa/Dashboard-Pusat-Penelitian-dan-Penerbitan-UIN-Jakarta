<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class FakultasTable extends Component
{
    #[Computed]
    public function fakultas(): array
    {
        // Data sesuai screenshot (total 353)
        return [
            ['nama' => 'Fakultas Ilmu Tarbiyah dan Keguruan', 'jumlah' => 45],
            ['nama' => 'Fakultas Adab dan Humaniora', 'jumlah' => 30],
            ['nama' => 'Fakultas Ushuluddin', 'jumlah' => 20],
            ['nama' => 'Fakultas Syariah dan Hukum', 'jumlah' => 35],
            ['nama' => 'Fakultas Ilmu Dakwah dan Komunikasi', 'jumlah' => 15],
            ['nama' => 'Fakultas Dirasat Islamiyah', 'jumlah' => 5],
            ['nama' => 'Fakultas Psikologi', 'jumlah' => 10],
            ['nama' => 'Fakultas Ekonomi dan Bisnis', 'jumlah' => 40],
            ['nama' => 'Fakultas Sains dan Teknologi', 'jumlah' => 50],
            ['nama' => 'Fakultas Ilmu Kesehatan', 'jumlah' => 25],
            ['nama' => 'Fakultas Kedokteran', 'jumlah' => 35],
            ['nama' => 'Fakultas Ilmu Sosial dan Ilmu Politik', 'jumlah' => 20],
            ['nama' => 'Sekolah Pasca Sarjana', 'jumlah' => 18],
            ['nama' => 'Unit Lain', 'jumlah' => 5],
        ];
    }

    #[Computed]
    public function totalKeseluruhan(): int
    {
        // Helper collect() sudah tersedia global
        return collect($this->fakultas())->sum('jumlah'); // 353
    }

    public function render()
    {
        return view('livewire.fakultas-table');
    }
}
