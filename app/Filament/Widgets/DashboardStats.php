<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\PenelitianByFakultas;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class DashboardStats extends BaseWidget
{
    protected ?string $heading = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Penelitian', 250)
                ->description('Total penelitian aktif')
                ->color('primary')
                ->url(PenelitianByFakultas::getUrl())
                ->extraAttributes(['class' => 'cursor-pointer']),

            Stat::make('Insentif', 1500)
                ->description('Jumlah insentif diberikan')
                ->color('success'),

            Stat::make('Tagihan Publikasi', 180)
                ->description('Tagihan yang diajukan')
                ->color('warning'),

            Stat::make('Bantuan Buku', 65)
                ->description('Buku diterbitkan')
                ->color('danger'),

            Stat::make('Registrasi Artikel', 210)
                ->description('Artikel terdaftar')
                ->color('primary'),
        ];
    }
}
