<?php

namespace App\Filament\Resources\TagihanPublikasis\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\TagihanPublikasi;
use Illuminate\Support\Facades\DB;

class TagihanPublikasiChart extends ChartWidget
{
    protected ?string $heading = 'Tagihan Publikasi Chart';

    protected function getData(): array
    {
        $data = TagihanPublikasi::query()
            ->select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Dokumen',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => 'rgba(var(--primary-500), 0.8)',
                    'borderColor' => 'rgb(var(--primary-600))',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->map(fn ($item) => $item->kategori ?: 'Tanpa Kategori')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
