<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;

class DashboardRiset extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';

    // Judul halaman
    protected static ?string $title = 'Pusat Penelitian dan Penerbitan UIN Jakarta';

    protected string $view = 'filament.pages.dashboard-riset';

    public static function getNavigationLabel(): string
    {
        return 'Dashboard Riset';
    }
}
