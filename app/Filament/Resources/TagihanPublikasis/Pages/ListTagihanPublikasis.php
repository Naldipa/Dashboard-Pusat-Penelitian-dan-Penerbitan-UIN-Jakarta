<?php

namespace App\Filament\Resources\TagihanPublikasis\Pages;

use App\Filament\Resources\TagihanPublikasis\TagihanPublikasiResource;
use App\Models\TagihanPublikasi;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ListTagihanPublikasis extends Page
{
    use WithFileUploads;

    protected static string $resource = TagihanPublikasiResource::class;

    protected ?string $heading = 'Rekapitulasi Tagihan Publikasi';

    // We use a custom blade view for the summary table
    protected string $view = 'filament.pages.list-tagihan-publikasis';

    public $fileExcel;
    public array $categories = [];
    public int $totalRecords = 0;

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Group by 'kategori' column (ensure this column exists in DB from previous migrations)
        // If your column name is different, change 'kategori' below.
        $this->categories = TagihanPublikasi::query()
            ->select('kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get()
            ->map(fn ($item) => [
                'nama' => $item->kategori ?: 'Tanpa Kategori', // Handle nulls
                'jumlah' => $item->jumlah
            ])
            ->toArray();

        $this->totalRecords = array_sum(array_column($this->categories, 'jumlah'));
    }

    public function importData(): void
    {
        $this->validate([
            'fileExcel' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($this->fileExcel->getRealPath(), 'r');
        $header = null;
        $count = 0;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                if ($header === null) {
                    $header = array_map(fn($h) => Str::snake(Str::lower(trim($h))), $row);
                    continue;
                }

                $data = [];
                foreach ($row as $i => $value) {
                    $key = $header[$i] ?? null;
                    if ($key) $data[$key] = trim($value);
                }

                if (empty($data['judul'])) continue;

                TagihanPublikasi::updateOrCreate(
                    ['no_reg' => $data['no_reg'] ?? null],
                    [
                        'judul'          => $data['judul'],
                        'ketua'          => $data['ketua'] ?? '-',
                        'fakultas'       => $data['fakultas'] ?? null,
                        'kategori'       => $data['kategori'] ?? 'Umum', // Ensure this maps correctly from CSV
                        'artikel_jurnal' => $data['artikel_jurnal'] ?? 'belum ada',
                        'proceeding'     => $data['proceeding'] ?? 'belum ada',
                        'haki'           => $data['haki'] ?? 'belum ada',
                        'buku'           => $data['buku'] ?? 'belum ada',
                    ]
                );

                $count++;
            }

            DB::commit();
            fclose($handle);
            $this->reset('fileExcel');
            $this->loadData(); // Refresh summary

            Notification::make()->title("Import Berhasil: {$count} data")->success()->send();

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            Notification::make()->title('Gagal Import')->body($e->getMessage())->danger()->send();
        }
    }
}
