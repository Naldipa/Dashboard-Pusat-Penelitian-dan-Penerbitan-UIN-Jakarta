<?php

namespace App\Filament\Resources\BookReferences\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class BookReferenceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Cover')
                    ->square(),

                TextColumn::make('judul')
                    ->label('Judul Buku')
                    ->limit(40)
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('penulis')
                    ->label('Penulis')
                    ->limit(30)
                    ->searchable(),

                TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Done' => 'success',
                        'Siap Cetak' => 'info',
                        default => 'gray',
                    }),
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
