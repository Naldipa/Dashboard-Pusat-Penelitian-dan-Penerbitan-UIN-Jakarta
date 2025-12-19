<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\TahunPenelitian;
use BackedEnum;

class DashboardRiset extends Page
{
    protected static ?string $title = 'Pusat Penelitian dan Penerbitan UIN Jakarta';
    protected string $view = 'filament.pages.dashboard-riset';

    public $years = [];
    public $selectedYear;

    public static function getNavigationLabel(): string
    {
        return 'Dashboard Riset';
    }

    public function mount()
    {
        $this->years = TahunPenelitian::query()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        $this->selectedYear = $this->years[0] ?? date('Y');
    }
}
