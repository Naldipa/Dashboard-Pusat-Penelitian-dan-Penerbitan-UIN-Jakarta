<?php

namespace App\Filament\Resources\ArticleRegistrations\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class ArticleRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('fakultas')
                    ->label('Fakultas')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('judul')
                    ->label('Judul Artikel')
                    ->limit(50)
                    ->wrap()
                    ->searchable(),

                TextColumn::make('jumlah_rp')
                    ->label('Insentif')
                    ->money('IDR')
                    ->sortable(),
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
