<?php

namespace App\Filament\Resources\ArticleRegistrations\Pages;

use App\Filament\Resources\ArticleRegistrations\ArticleRegistrationResource;
use App\Models\ArticleRegistration;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use App\Filament\Resources\ArticleRegistrations\Widgets\ArticleRegistrationChart;

class ListArticleRegistrations extends ListRecords
{
    use WithFileUploads;

    protected static string $resource = ArticleRegistrationResource::class;

    protected string $view = 'filament.pages.list-article-registrations';

    public $fileExcel;
    public $isImportOpen = false;

    public $fakultasSummary = [];
    public $totalKeseluruhan = 0;
    public $totalUang = 0;

    public function mount(): void
    {
        parent::mount();
        $this->loadData();
    }

    protected function getFooterWidgets(): array
    {
        return [
            ArticleRegistrationChart::class,
        ];
    }

    public function loadData()
    {
        $this->fakultasSummary = ArticleRegistration::query()
            ->select('fakultas', DB::raw('count(*) as jumlah'), DB::raw('sum(jumlah_rp) as total_rp'))
            ->whereNotNull('fakultas')
            ->where('fakultas', '!=', '')
            ->groupBy('fakultas')
            ->orderByDesc('jumlah')
            ->get()
            ->map(fn ($item) => [
                'nama' => $item->fakultas,
                'jumlah' => $item->jumlah,
                'total_rp' => $item->total_rp
            ])
            ->toArray();

        $this->totalKeseluruhan = array_sum(array_column($this->fakultasSummary, 'jumlah'));
        $this->totalUang = array_sum(array_column($this->fakultasSummary, 'total_rp'));
    }

    public function importData()
    {
        $this->validate([
            'fileExcel' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($this->fileExcel->getRealPath(), 'r');
        $count = 0;

        DB::beginTransaction();
        try {
            // Logic taken from your original ArticleRegistrationData
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                ArticleRegistration::create([
                    'nama'      => $row[0] ?? 'Unknown',
                    'fakultas'  => $row[1] ?? 'Unit Lain',
                    'judul'     => $row[2] ?? '-',
                    'jumlah_rp' => isset($row[3])
                        ? (float) preg_replace('/[^0-9]/', '', $row[3])
                        : 0,
                ]);

                $count++;
            }

            DB::commit();
            fclose($handle);
            $this->reset(['fileExcel', 'isImportOpen']);
            $this->loadData(); // Refresh summary and table

            Notification::make()->title("Berhasil import {$count} artikel.")->success()->send();

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
        }
    }
}
