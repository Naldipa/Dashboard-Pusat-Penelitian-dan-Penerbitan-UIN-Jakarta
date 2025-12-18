<?php

namespace App\Filament\Widgets;

use App\Models\Penelitian;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DashboardData extends ChartWidget
{
    protected ?string $heading = 'Tren Proposal Penelitian Diterima vs Ditolak';

    protected ?string $pollingInterval = null;

    protected function getData(): array
    {
        $years = [2021, 2022, 2023, 2024, 2025];

        $statusDiterima = ['Selesai', 'Diterima', 'Disetujui', 'Dibayar'];
        $statusDitolak  = ['Proses', 'Perencanaan', 'Ditolak', 'Diproses', 'Tertunda'];

        $rawData = Penelitian::query()
            ->select('tahun', 'status', DB::raw('count(*) as total'))
            ->whereIn('tahun', $years)
            ->groupBy('tahun', 'status')
            ->get();

        $dataDiterima = [];
        $dataDitolak = [];

        foreach ($years as $year) {
            $yearRecords = $rawData->where('tahun', $year);

            $dataDiterima[] = $yearRecords->whereIn('status', $statusDiterima)->sum('total');
            $dataDitolak[]  = $yearRecords->whereIn('status', $statusDitolak)->sum('total');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ditolak / Proses',
                    'data' => $dataDitolak,
                    'backgroundColor' => '#EF4444',
                    'barPercentage' => 0.5,
                ],
                [
                    'label' => 'Diterima',
                    'data' => $dataDiterima,
                    'backgroundColor' => '#10B981',
                    'barPercentage' => 0.5,
                ],
            ],
            'labels' => $years,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
            'scales' => [
                'x' => [
                    'stacked' => true,
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'stacked' => true,
                    'ticks' => [
                        'stepSize' => 20,
                    ],
                ],
            ],
        ];
    }
}
