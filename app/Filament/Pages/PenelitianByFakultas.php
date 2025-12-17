<?php

namespace App\Filament\Pages;

use App\Models\Penelitian;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithFileUploads as LivewireWithFileUploads;

class PenelitianByFakultas extends Page
{
    use WithFileUploads;

    protected static ?string $slug = 'penelitian';
    protected string $view = 'filament.pages.penelitian-by-fakultas';

    public $fileExcel;

    public array $fakultas = [];
    public int $totalKeseluruhan = 0;

    public function mount(): void
    {
        $this->refreshStats();
    }

    public function refreshStats()
    {
        $data = Penelitian::query()
            ->select('fakultas', DB::raw('count(*) as total'))
            ->groupBy('fakultas')
            ->orderBy('total', 'desc')
            ->get();

        $this->fakultas = $data->map(function ($item) {
            return [
                'nama' => $item->fakultas,
                'jumlah' => $item->total,
            ];
        })->toArray();

        $this->totalKeseluruhan = Penelitian::count();
    }

    public function importData()
    {
        $this->validate([
            'fileExcel' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $path = $this->fileExcel->getRealPath();
        $handle = fopen($path, 'r');

        fgetcsv($handle);

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            Penelitian::create([
                'judul'           => $row[0] ?? 'No Title',
                'fakultas'        => $row[1] ?? 'Uncategorized',
                'penulis_utama'   => $row[2] ?? 'Anonim',
                'anggota_penulis' => $row[3] ?? null,
                'tahun'           => (int) ($row[4] ?? date('Y')),
                'status'          => $row[5] ?? 'Proses',
                'abstrak'         => $row[6] ?? null,
            ]);
        }

        fclose($handle);

        $this->reset('fileExcel');

        $this->refreshStats();

        Notification::make()
            ->title('Upload Berhasil')
            ->body('Data penelitian telah berhasil diimpor.')
            ->success()
            ->send();
    }
}
