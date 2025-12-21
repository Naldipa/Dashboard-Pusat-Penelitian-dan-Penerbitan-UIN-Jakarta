<?php

namespace App\Filament\Pages;

use App\Models\Penelitian;
use App\Models\TahunPenelitian;
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

    public $activeView = 'table';
    public $selectedYear;
    public $years = [];

    public function mount(): void
    {
        $this->years = TahunPenelitian::orderBy('tahun', 'desc')->pluck('tahun')->toArray();

        $activeYear = TahunPenelitian::where('isActive', 1)->first();
        $this->selectedYear = $activeYear->tahun;

        $this->loadData();
    }

    public function loadData()
    {
        $this->fakultas = Penelitian::query()
            ->select('fakultas', DB::raw('count(*) as jumlah'))
            ->whereNotNull('fakultas')
            ->where('tahun', $this->selectedYear)
            ->groupBy('fakultas')
            ->orderByDesc('jumlah')
            ->get()
            ->map(fn ($item) => [
                'nama' => $item->fakultas,
                'jumlah' => $item->jumlah
            ])
            ->toArray();

        $this->totalKeseluruhan = array_sum(array_column($this->fakultas, 'jumlah'));
    }

    public function updatedSelectedYear()
    {
        $this->loadData();
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

                $activeYear = TahunPenelitian::where('isActive', 1)->first()->tahun;

                Penelitian::create([
                    'judul'           => $row[2] ?? 'Untitled',
                    'fakultas_id'     => $fakultas->id,
                    'fakultas' => $fakultas->nama,
                    'penulis_utama'   => $cleanName,
                    'anggota_penulis' => null,
                    'tahun'           => $activeYear,
                    'status'          => 'Proses',
                    'abstrak'         => $row[3] ?? null,
                ]);
            }

            DB::commit();

            $this->reset('fileExcel');
            $this->loadData();
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
