<?php

namespace App\Filament\Resources\Penelitians\Pages;

use App\Filament\Resources\Penelitians\PenelitianResource;
use App\Models\Penelitian;
use Filament\Resources\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

class PenelitianFakultasDetail extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = PenelitianResource::class;

    protected string $view = 'filament.pages.penelitian-fakultas-detail';

    public $fakultas;

    public function mount($fakultas): void
    {
        $this->fakultas = $fakultas;
    }

    public function getHeading(): string
    {
        return $this->fakultas;
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
                TextColumn::make('judul')->searchable()->wrap()->limit(60),
                TextColumn::make('id_register')->sortable(),
                TextColumn::make('penulis_utama')->label('Penulis'),
                TextColumn::make('jabatan'),
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
            ->recordActions([
                Action::make('edit')
                    ->icon('heroicon-m-pencil-square')
                    ->label('Edit')
                    ->modalWidth('2xl')
                    ->modalHeading('Edit Penelitian')
                    ->form([
                        TextInput::make('judul')->required()->columnSpan(2),
                        TextInput::make('penulis_utama')->required(),
                        TextInput::make('tahun')->numeric()->required(),
                        TextInput::make('penulis_dua')->string(),
                        TextInput::make('penulis_tiga')->string(),
                        TextInput::make('jabatan')->string(),
                        TextInput::make('tahun')->numeric()->required(),
                        Select::make('status')
                            ->options([
                                'Proses' => 'Proses',
                                'Selesai' => 'Selesai',
                                'Diterima' => 'Diterima',
                                'Ditolak' => 'Ditolak',
                            ])->required(),
                        Textarea::make('klaster')->rows(3)->columnSpan(2),
                    ])
                    ->fillForm(fn (Penelitian $record): array => $record->attributesToArray())
                    ->action(function (Penelitian $record, array $data): void {
                        $record->update($data);
                        Notification::make()->title('Data berhasil disimpan')->success()->send();
                    }),

                Action::make('delete')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Penelitian $record) => $record->delete()),
            ]);
    }
}
