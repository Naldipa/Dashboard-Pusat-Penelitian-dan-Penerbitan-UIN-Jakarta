<?php

namespace App\Filament\Resources\Fakultas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class FakultasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Fakultas')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('kode')
                    ->label('Kode')
                    ->badge()
                    ->color(fn ($record) => $record->warna) // Use the color from DB
                    ->searchable(),

               TextColumn::make('penelitian_count')
                    ->counts('penelitian') // Automatic relationship count
                    ->label('Jml. Penelitian')
                    ->alignCenter(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
