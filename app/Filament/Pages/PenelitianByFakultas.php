<?php

namespace App\Filament\Pages;

use App\Models\Penelitian;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
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

    public function importData(): void
    {
        $this->validate([
            'fileExcel' => 'required|mimes:csv,txt|max:10240'
        ]);

        $path = $this->fileExcel->getRealPath();
        $handle = fopen($path, 'r');

        fgetcsv($handle);

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {

                $rawName = $row[0] ?? 'Anonim';
                $cleanName = trim(str_ireplace('(KETUA)', '', $rawName));

                $kodeFakultas = isset($row[4]) ? trim($row[4]) : 'N/A';

                $fakultas = \App\Models\Fakultas::firstOrCreate(
                    ['kode' => $kodeFakultas],
                    ['nama' => 'Fakultas ' . $kodeFakultas]
                );

                Penelitian::create([
                    'judul'           => $row[2] ?? 'Untitled',
                    'fakultas_id'     => $fakultas->id,
                    'fakultas' => $fakultas->nama,
                    'penulis_utama'   => $cleanName,
                    'anggota_penulis' => null,
                    'tahun'           => date('Y'),
                    'status'          => 'Proses',
                    'abstrak'         => $row[3] ?? null,
                ]);
            }

            DB::commit();

            $this->reset('fileExcel');
            $this->refreshStats();
            Notification::make()->title('Data Berhasil Diimpor')->success()->send();

        } catch (\Exception $e) {
            DB::rollBack();
            Notification::make()
                ->title('Gagal Impor')
                ->body('Error pada baris data: ' . $e->getMessage())
                ->danger()
                ->send();
        }

        fclose($handle);
    }
}
