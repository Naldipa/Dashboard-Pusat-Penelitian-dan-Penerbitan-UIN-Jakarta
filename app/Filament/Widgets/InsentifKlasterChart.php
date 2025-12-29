<?php

namespace App\Filament\Widgets;

use App\Models\Penelitian;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class InsentifKlasterChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Insentif per Klaster';
    protected string $color = 'primary';

    public ?int $filterYear = null;

    protected function getData(): array
    {
        $year = $this->filterYear ?? date('Y');

        $data = Penelitian::query()
            ->select('klaster', DB::raw('count(*) as total'))
            ->whereNotNull('klaster')
            ->where('tahun', $year)
            ->groupBy('klaster')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Insentif',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => '#f5930b',
                    'borderColor' => '#d97706',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->pluck('klaster')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
