<?php

namespace App\Filament\Resources\TagihanPublikasis\Pages;

use App\Filament\Resources\TagihanPublikasis\TagihanPublikasiResource;
use App\Models\TagihanPublikasi;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ListTagihanPublikasis extends ListRecords
{
    use WithFileUploads;

    protected static string $resource = TagihanPublikasiResource::class;

    protected string $view = 'filament.pages.list-tagihan-publikasis';

    public $fileExcel;

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
                    $header = array_map(
                        fn($h) => Str::snake(Str::lower(trim($h))),
                        $row
                    );
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

            Notification::make()
                ->title("Import Berhasil")
                ->body("Berhasil mengimpor {$count} data tagihan.")
                ->success()
                ->send();

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);

            Notification::make()
                ->title('Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
