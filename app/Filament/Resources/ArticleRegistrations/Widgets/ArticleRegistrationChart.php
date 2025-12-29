<?php

namespace App\Filament\Resources\ArticleRegistrations\Widgets;

use App\Models\ArticleRegistration;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ArticleRegistrationChart extends ChartWidget
{
    protected ?string $heading = 'Statistik Artikel per Fakultas';

    protected function getData(): array
    {
        $data = ArticleRegistration::query()
            ->select('fakultas', DB::raw('count(*) as total'))
            ->whereNotNull('fakultas')
            ->where('fakultas', '!=', '')
            ->groupBy('fakultas')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Artikel',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => '#f5930b',
                    'borderColor' => '#d97706',
                    'borderWidth' => 1,
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
