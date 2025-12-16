<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class DashboardChart extends ChartWidget
{
    protected ?string $heading = 'Total Kumulatif 5 Tahun';

    protected function getData(): array
    {
        $years = [2021, 2022, 2023, 2024, 2025];

        return [
            'datasets' => [
                [
                    'label' => 'Penelitian',
                    'data' => [50, 60, 70, 40, 80],
                    'backgroundColor' => '#6366F1',
                ],
                [
                    'label' => 'Insentif',
                    'data' => [100, 120, 150, 90, 160],
                    'backgroundColor' => '#10B981',
                ],
                [
                    'label' => 'Tagihan',
                    'data' => [35, 40, 50, 30, 60],
                    'backgroundColor' => '#FACC15',
                ],
                [
                    'label' => 'Buku',
                    'data' => [15, 20, 10, 5, 25],
                    'backgroundColor' => '#EF4444',
                ],
                [
                    'label' => 'Registrasi',
                    'data' => [45, 55, 60, 50, 70],
                    'backgroundColor' => '#A855F7',
                ],
            ],
            'labels' => $years,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
