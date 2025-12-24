<?php

namespace App\Filament\Pages;

use App\Models\ArticleRegistration;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ArticleRegistrationData extends Page
{
    use WithFileUploads;

    protected static ?string $navigationLabel = 'Registrasi Artikel';
    protected static ?string $title = 'Data Registrasi Artikel';
    protected static ?string $slug = 'registrasi-artikel';

    protected string $view = 'filament.pages.article-registration-data';

    public $fileExcel;
    public $isImportOpen = false;

    // Data properties
    public $fakultasSummary = [];
    public $totalKeseluruhan = 0;
    public $totalUang = 0;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Aggregate data by Fakultas
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
        $header = null;
        $count = 0;

        DB::beginTransaction();
        try {
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
            $this->loadData(); // Refresh table

            Notification::make()->title("Berhasil import {$count} artikel.")->success()->send();

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
        }
    }
}
