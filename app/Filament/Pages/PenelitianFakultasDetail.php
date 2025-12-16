<?php

namespace App\Filament\Pages;

use App\Models\Penelitian;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenelitianFakultasDetail extends Page
{
    protected static BackedEnum|string|null $navigationIcon = null;
    protected static ?string $navigationLabel = null;
    protected static ?string $title = 'Data Penelitian per Fakultas';
    protected static ?string $slug = 'penelitian-fakultas';

    protected string $view = 'filament.pages.penelitian-fakultas-detail';

    public string $fakultas = '';

    public $diterima;
    public $ditolak;
    public int $totalDokumen = 0;

    // ➕ untuk modal
    public ?Penelitian $selectedPenelitian = null;
    public bool $showDetailModal = false;

    public function mount(Request $request): void
    {
        $this->fakultas = $request->query('fakultas', '');

        $base = Penelitian::query()
            ->where('fakultas', $this->fakultas);

        $this->diterima = (clone $base)
            ->whereIn('status', ['DITERIMA', 'DISETUJUI', 'DIBAYAR'])
            ->orderByDesc('tahun')
            ->get();

        $this->ditolak = (clone $base)
            ->whereIn('status', ['DITOLAK', 'DIPROSES', 'TERTUNDA'])
            ->orderByDesc('tahun')
            ->get();

        $this->totalDokumen = $this->diterima->count() + $this->ditolak->count();
    }

    // ➕ dipanggil saat klik "Lihat Data"
    public function showDetail(int $id): void
    {
        $this->selectedPenelitian = Penelitian::findOrFail($id);
        $this->showDetailModal = true;
    }

    public static function getNavigationGroup(): ?string
    {
        return null;
    }
}
