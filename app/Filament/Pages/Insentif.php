<?php

namespace App\Filament\Pages;

use App\Models\Penelitian;
use App\Models\TahunPenelitian;
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

        DB::beginTransaction();

        try {
            $activeYear = TahunPenelitian::where('isActive', 1)->first()->tahun;
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

                if (empty($data['judul'])) {
                    continue;
                }


                Penelitian::create([
                    'judul'           => $data['judul'],
                    'penulis_utama'   => $data['nama'] ?? 'Anonim',
                    'klaster'         => $data['kategori'] ?? null,
                    'biaya_insentif'  => isset($row[4])
                        ? (int) preg_replace('/[^0-9]/', '', $row[4]) // Remove 'Rp', '.', etc
                        : 0,
                    'tahun'           => $activeYear,
                    'anggota_penulis' => null,
                    'nama_jurnal'     => null,
                    'abstrak'         => null,
                    'file_path'       => null,
                    'id_register'     => null,
                ]);

                $count++;
            }

            DB::commit();
            fclose($handle);

            // Reset & reload
            $this->reset('fileExcel');
            $this->loadData();

            Notification::make()
                ->title('Import Berhasil')
                ->body("Berhasil mengimpor {$count} data insentif.")
                ->success()
                ->send();

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);

            Notification::make()
                ->title('Gagal Impor')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Insentif';
    }
}
