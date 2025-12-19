<?php

namespace App\Filament\Widgets;

use App\Models\Penelitian;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    public string|int|null $filterYear = 'all';

    protected function getStats(): array
    {
        $query = Penelitian::query();

        if ($this->filterYear !== 'all') {
            $query->where('tahun', $this->filterYear);
            $desc = "Periode " . $this->filterYear;
        } else {
            $desc = "Semua Periode";
        }

        $countPenelitian = (clone $query)->count();

        $countInsentif = (clone $query)
            ->where(function($q) {
                $q->whereNotNull('klaster')
                  ->orWhereNotNull('biaya_insentif');
            })
            ->count();

        $countTagihan = (clone $query)
            ->whereNotNull('nama_jurnal')
            ->count();

        $countBuku = (clone $query)
            ->where('klaster', 'LIKE', '%Buku%')
            ->count();

        $countRegister = (clone $query)
            ->whereNotNull('id_register')
            ->count();

        return [
            Stat::make('Penelitian', $countPenelitian)
                ->description('Total penelitian aktif')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('primary'),

            Stat::make('Insentif', $countInsentif)
                ->description('Jumlah insentif diberikan')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Tagihan Publikasi', $countTagihan)
                ->description('Tagihan yang diajukan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),

            Stat::make('Bantuan Buku', $countBuku)
                ->description('Buku diterbitkan')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('danger'),

            Stat::make('Registrasi Artikel', $countRegister)
                ->description('Artikel terdaftar')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('info'),
        ];
    }
}
