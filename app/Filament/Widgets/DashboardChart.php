<?php

namespace App\Filament\Widgets;

use App\Models\Penelitian;
use App\Models\BookReference;
use App\Models\ArticleRegistration;
use App\Models\TagihanPublikasi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Pages\PenelitianByFakultas;

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

        $countTagihan = TagihanPublikasi::count();
        $countBook = BookReference::count();

        $countRegister = ArticleRegistration::count();
        return [
            Stat::make('Penelitian', $countPenelitian)
                ->description('Total penelitian aktif')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('primary')
                ->url('/admin/penelitians'),

            Stat::make('Insentif', $countInsentif)
                ->description('Jumlah insentif diberikan')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->url('/admin/insentif'),

            Stat::make('Tagihan Publikasi', $countTagihan)
                ->description('Tagihan yang diajukan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning')
                ->url('/admin/tagihan-publikasi'),

            Stat::make('Bantuan Buku', $countBook)
                ->description('Buku diterbitkan')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('danger')
                ->url('/admin/referensi-buku'),

            Stat::make('Registrasi Artikel', $countRegister)
                ->description('Artikel terdaftar')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('info')
                ->url('/admin/article-registrations'),
        ];
    }
}
