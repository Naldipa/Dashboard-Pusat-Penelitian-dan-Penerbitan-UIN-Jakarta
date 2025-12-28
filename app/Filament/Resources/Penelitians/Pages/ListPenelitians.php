<?php

namespace App\Filament\Resources\Penelitians\Pages;

use App\Filament\Resources\Penelitians\PenelitianResource;
use App\Models\Penelitian;
use App\Models\TahunPenelitian;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class ListPenelitians extends Page
{
    use WithFileUploads;

    protected static string $resource = PenelitianResource::class;

    protected ?string $heading = 'Data Penelitian Per Fakultas';

    protected string $view = 'filament.pages.list-penelitians';

    public $activeView = 'table'; // 'table' or 'chart'

    public $fileExcel;
    public array $fakultas = [];
    public int $totalKeseluruhan = 0;
    public $selectedYear;
    public $years = [];

    public function mount(): void
    {
        $this->years = TahunPenelitian::orderBy('tahun', 'desc')->pluck('tahun')->toArray();

        $activeYear = TahunPenelitian::where('isActive', 1)->first();
        $this->selectedYear = $activeYear->tahun ?? date('Y');

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
        // If chart is active, Livewire will automatically re-render the widget because we pass the year as key
    }

    public function importData(): void
    {
        $this->validate([
            'fileExcel' => 'required|mimes:csv,txt|max:10240'
        ]);

        $path = $this->fileExcel->getRealPath();
        $handle = fopen($path, 'r');
        fgetcsv($handle); // Skip header

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
                    'judul'         => $row[2] ?? 'Untitled',
                    'id_register'         => $row[1] ?? null,
                    'fakultas_id'   => $fakultas->id,
                    'fakultas'      => $fakultas->nama,
                    'penulis_utama' => $cleanName,
                    'tahun'         => $this->selectedYear,
                    'status'        => 'Proses',
                    'abstrak'       => $row[3] ?? null,
                ]);
            }

            DB::commit();
            $this->reset('fileExcel');
            $this->loadData();
            Notification::make()->title('Data Berhasil Diimpor')->success()->send();

        } catch (\Exception $e) {
            DB::rollBack();
            Notification::make()->title('Gagal Impor')->body($e->getMessage())->danger()->send();
        }
        fclose($handle);
    }
}
