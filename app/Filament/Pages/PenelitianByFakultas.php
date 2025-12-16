<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;

class PenelitianByFakultas extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $title = 'Daftar Dokumen & Data Penulis Berdasarkan Fakultas';

    protected static ?string $navigationLabel = 'Penelitian';

    // URL dalam panel: /admin/penelitian
    protected static ?string $slug = 'penelitian';

    protected string $view = 'filament.pages.penelitian-by-fakultas';

    /** @var array<int, array{nama:string, jumlah:int}> */
    public array $fakultas = [];

    public int $totalKeseluruhan = 0;

    public function mount(): void
    {
        // Data rekap statik sesuai yang kamu mau (total 353)
        $this->fakultas = [
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

        $this->totalKeseluruhan = array_sum(array_column($this->fakultas, 'jumlah')); // 353
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Riset & Publikasi';
    }
}
