<?php

namespace App\Filament\Widgets;

use App\Models\Penelitian;
use App\Models\TahunPenelitian;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;


class DashboardData extends ChartWidget
{
    protected ?string $heading = 'Tren Proposal Penelitian Diterima vs Ditolak';

    protected ?string $pollingInterval = null;

    public string|int|null $filterYear = 'all';

    protected function getData(): array
    {
        if ($this->filterYear === 'all') {
            $years = TahunPenelitian::orderBy('tahun', 'asc')->pluck('tahun')->toArray();
        } else {
            $years = [$this->filterYear];
        }

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
                    'label' => 'Proses / Ditolak',
                    'data' => $dataDitolak,
                    'backgroundColor' => '#EF4444',
                    'barPercentage' => 0.5,
                ],
                [
                    'label' => 'Diterima / Selesai',
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
