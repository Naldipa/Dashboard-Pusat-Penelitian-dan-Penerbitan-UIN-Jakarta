<?php

namespace App\Filament\Widgets;

use App\Models\Penelitian;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class FakultasChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Penelitian per Fakultas';

    public int|string|null $filterYear = null;

    protected function getData(): array
    {
        $year = $this->filterYear ?? date('Y');

        $data = Penelitian::query()
            ->select('fakultas', DB::raw('count(*) as total'))
            ->whereNotNull('fakultas')
            ->where('tahun', $year)
            ->groupBy('fakultas')
            ->orderByDesc('total')
            ->limit(10) // Limit to top 10 for cleaner graph
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Dokumen',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#d97706',
                ],
            ],
            'labels' => $data->pluck('fakultas')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
