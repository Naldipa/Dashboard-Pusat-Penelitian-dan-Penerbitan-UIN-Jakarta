<?php

namespace App\Filament\Resources\TagihanPublikasis\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class TagihanPublikasiTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_reg')
                    ->label('No. Reg')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('judul')
                    ->wrap()
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('ketua')
                    ->label('Ketua Peneliti')
                    ->searchable(),

                TextColumn::make('fakultas')
                    ->searchable()
                    ->toggleable(),

                // Status Columns
                TextColumn::make('artikel_jurnal')
                    ->label('Jurnal')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'belum ada' ? 'gray' : 'success'),

                TextColumn::make('proceeding')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'belum ada' ? 'gray' : 'success')
                    ->toggleable(),

                TextColumn::make('haki')
                    ->label('HAKI')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'belum ada' ? 'gray' : 'success')
                    ->toggleable(),

                TextColumn::make('buku')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'belum ada' ? 'gray' : 'success')
                    ->toggleable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
