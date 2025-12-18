<?php

namespace App\Filament\Pages;

use App\Models\Penelitian;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Insentif extends Page
{
    use WithFileUploads;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Insentif';
    protected static ?string $title = 'Rekap Insentif Berdasarkan Klaster';
    protected static ?string $slug = 'insentif';

    protected string $view = 'filament.pages.insentif';

    /** Upload CSV */
    public $fileExcel;

    /** Data tabel */
    public array $klaster = [];
    public int $totalKeseluruhan = 0;

    public function mount(): void
    {
        $this->loadData();
    }

    protected function loadData(): void
    {
        $rows = Penelitian::select(
                DB::raw('COALESCE(klaster, "Tidak Ditentukan") as klaster'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('klaster')
            ->orderBy('klaster')
            ->get();

        $this->klaster = $rows->map(fn ($row) => [
            'nama'   => $row->klaster,
            'jumlah' => (int) $row->total,
        ])->toArray();

        $this->totalKeseluruhan = $rows->sum('total');
    }

    public function importData(): void
    {
        $this->validate([
            'fileExcel' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($this->fileExcel->getRealPath(), 'r');
        $header = null;
        $count  = 0;

        while (($row = fgetcsv($handle, 0, ',')) !== false) {

            if ($header === null) {
                $header = array_map(
                    fn ($h) => Str::of($h)->lower()->trim()->toString(),
                    $row
                );
                continue;
            }

            $data = [];
            foreach ($row as $i => $value) {
                $key = $header[$i] ?? null;
                if ($key) {
                    $data[$key] = trim($value);
                }
            }

            // Minimal validasi
            if (empty($data['judul']) || empty($data['klaster'])) {
                continue;
            }

            Penelitian::create([
                'penulis_utama'  => $data['nama'] ?? '-',
                'judul'          => $data['judul'],
                'nama_jurnal'    => $data['nama jurnal'] ?? null,
                'klaster'        => $data['klaster'],
                'biaya_insentif' => isset($data['biaya'])
                    ? (int) preg_replace('/[^0-9]/', '', $data['biaya'])
                    : null,
                'fakultas'       => 'Unit Lain',
                'tahun'          => 2021,
                'status'         => 'Dibayar',
            ]);

            $count++;
        }

        fclose($handle);

        // Reset & reload
        $this->reset('fileExcel');
        $this->loadData();

        Notification::make()
        ->title('Import Berhasil')
        ->body("Berhasil mengimpor {$count} data insentif.")
        ->success()
        ->send();
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Riset & Publikasi';
    }
}
