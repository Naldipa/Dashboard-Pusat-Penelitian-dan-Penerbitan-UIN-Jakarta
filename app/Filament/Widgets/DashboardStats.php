<?php

namespace App\Filament\Widgets;

use App\Models\Penelitian;
use App\Filament\Pages\PenelitianByFakultas;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Pages\Insentif;


class DashboardStats extends BaseWidget
{
    protected ?string $heading = null;
    public string|int|null $filterYear = 'all';

    protected function getStats(): array
    {
        $query = Penelitian::query();

        if ($this->filterYear !== 'all') {
            $query->where('tahun', $this->filterYear);
            $label = "Periode " . $this->filterYear;
        } else {
            $label = "Semua Periode";
        }

        $total         = (clone $query)->count();
        $totalDiterima = (clone $query)->whereIn('status', ['Selesai', 'Diterima', 'Disetujui', 'Dibayar'])->count();
        $totalProses   = (clone $query)->whereIn('status', ['Proses', 'Perencanaan', 'Ditolak', 'Diproses'])->count();

        return [
            Stat::make('Total Proposal', $total)
                ->description($label)
                ->color('primary'),

            Stat::make('Diterima / Selesai', $totalDiterima)
                ->description('Status Selesai')
                ->color('success'),

            Stat::make('Dalam Proses', $totalProses)
                ->description('Menunggu / Ditolak')
                ->color('warning'),
        ];
    }
}
