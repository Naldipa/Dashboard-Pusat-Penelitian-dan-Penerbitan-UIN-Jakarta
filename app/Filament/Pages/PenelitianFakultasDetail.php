<?php

namespace App\Filament\Pages;

use App\Models\Penelitian;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class PenelitianFakultasDetail extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static ?string $slug = 'penelitian-fakultas';
    protected string $view = 'filament.pages.penelitian-fakultas-detail';

    public string $fakultas = '';
    public $diterima;
    public $ditolak;
    public int $totalDokumen = 0;

    public ?array $data = [];
    public ?Penelitian $selectedPenelitian = null;
    public bool $isEditModalOpen = false;

    protected $queryString = ['fakultas'];

    public function mount(Request $request): void
    {
        $this->fakultas = $request->query('fakultas', '');
        $this->loadData();
        $this->form->fill();
    }

    public function loadData(): void
    {
        $base = Penelitian::query()->where('fakultas', $this->fakultas);

        $this->diterima = (clone $base)
            ->whereIn('status', ['Selesai', 'DITERIMA', 'DISETUJUI', 'DIBAYAR'])
            ->get();

        $this->ditolak = (clone $base)
            ->whereIn('status', ['Proses', 'Perencanaan', 'DITOLAK', 'DIPROSES', 'TERTUNDA'])
            ->get();

        $this->totalDokumen = $this->diterima->count() + $this->ditolak->count();
    }

    /**
     * Using columns(2) on the schema instead of the Grid component
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul')
                    ->label('Judul Penelitian')
                    ->required()
                    ->columnSpan(2), // Takes full width in a 2-column grid

                TextInput::make('penulis_utama')
                    ->label('Penulis Utama')
                    ->required(),

                TextInput::make('tahun')
                    ->numeric()
                    ->required(),

                Select::make('status')
                    ->options([
                        'Proses' => 'Proses',
                        'Selesai' => 'Selesai',
                        'DITERIMA' => 'Diterima',
                        'DITOLAK' => 'Ditolak',
                    ])
                    ->required(),

                Textarea::make('abstrak')
                    ->label('Abstrak')
                    ->rows(3)
                    ->columnSpan(2),
            ])
            ->columns(2) // This sets the grid for the entire form
            ->statePath('data')
            ->model($this->selectedPenelitian ?? Penelitian::class);
    }

    public function edit(int $id): void
    {
        $this->selectedPenelitian = Penelitian::findOrFail($id);
        $this->form->fill($this->selectedPenelitian->attributesToArray());
        $this->isEditModalOpen = true;
    }

    public function save(): void
    {
        $formData = $this->form->getState();
        $this->selectedPenelitian->update($formData);

        Notification::make()
            ->title('Data Berhasil Disimpan')
            ->success()
            ->send();

        $this->isEditModalOpen = false;
        $this->loadData();
    }
}
