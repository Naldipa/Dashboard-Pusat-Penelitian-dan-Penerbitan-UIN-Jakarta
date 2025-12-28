<?php

namespace App\Filament\Pages;

use App\Models\Penelitian;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action; // For Edit/Delete if needed
use Illuminate\Http\Request;
use UnitEnum;

class InsentifData extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $slug = 'insentif-data';
    protected static ?string $title = 'Detail Klaster Insentif';
    protected static string|UnitEnum|null $navigationGroup = "Insentif";

    protected string $view = 'filament.pages.insentif-data';

    public string $klaster = '';

    protected $queryString = ['klaster'];

    public function mount(Request $request): void
    {
        $this->klaster = $request->query('klaster', '');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Penelitian::query()
                    ->where('klaster', $this->klaster)
                    ->orderByDesc('tahun')
            )
            ->columns([
                TextColumn::make('judul')
                    ->searchable()
                    ->wrap()
                    ->limit(60),

                TextColumn::make('penulis_utama')
                    ->label('Penulis'),

                TextColumn::make('biaya_insentif')
                    ->money('IDR')
                    ->sortable()
                    ->label('Insentif'),

                TextColumn::make('tahun')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'dibayar', 'selesai' => 'success',
                        'proses' => 'warning',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->actions([]);
    }
}
