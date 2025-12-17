<?php

namespace App\Filament\Pages;

use App\Models\Penelitian;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Action; // <--- The generic Action class you wanted
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class PenelitianFakultasDetail extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $slug = 'penelitian-fakultas';
    protected string $view = 'filament.pages.penelitian-fakultas-detail';

    public string $fakultas = '';
    protected $queryString = ['fakultas'];

    public function mount(Request $request): void
    {
        $this->fakultas = $request->query('fakultas', '');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Penelitian::query()
                    ->where('fakultas', $this->fakultas)
                    ->orderByDesc('tahun')
            )
            ->columns([
                TextColumn::make('judul')->searchable()->wrap(),
                TextColumn::make('penulis_utama'),
                TextColumn::make('tahun')->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'selesai', 'diterima', 'disetujui' => 'success',
                        'proses', 'perencanaan' => 'info',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
            ])
            // THIS IS THE PART YOU WANTED
            ->recordActions([
                Action::make('edit')
                    ->icon('heroicon-m-pencil-square')
                    ->label('Edit Data')
                    ->modalWidth('2xl')
                    ->modalHeading('Edit Penelitian')
                    // 1. Define the form schema directly on the generic action
                    ->form([
                        TextInput::make('judul')->required()->columnSpan(2),
                        TextInput::make('penulis_utama')->required(),
                        TextInput::make('tahun')->numeric()->required(),
                        Select::make('status')
                            ->options([
                                'Proses' => 'Proses',
                                'Selesai' => 'Selesai',
                                'Diterima' => 'Diterima',
                                'Ditolak' => 'Ditolak',
                            ])->required(),
                        Textarea::make('abstrak')->rows(3)->columnSpan(2),
                    ])
                    // 2. Load the data into the form
                    ->fillForm(fn (Penelitian $record): array => $record->attributesToArray())
                    // 3. Handle the save logic
                    ->action(function (Penelitian $record, array $data): void {
                        $record->update($data);
                        Notification::make()->title('Data berhasil disimpan')->success()->send();
                    }),

                // Example of a Delete action using the same generic pattern
                Action::make('delete')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Penelitian $record) => $record->delete()),
            ]);
    }
}
