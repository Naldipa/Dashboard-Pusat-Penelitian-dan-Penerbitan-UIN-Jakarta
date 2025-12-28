<?php

namespace App\Filament\Resources\Penelitians\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PenelitiansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->searchable(),
                TextColumn::make('nama_jurnal')
                    ->searchable(),
                TextColumn::make('klaster')
                    ->searchable(),
                TextColumn::make('biaya_insentif')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fakultas')
                    ->searchable(),
                TextColumn::make('penulis_utama')
                    ->searchable(),
                TextColumn::make('anggota_penulis')
                    ->searchable(),
                TextColumn::make('tahun')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('file_path')
                    ->searchable(),
                TextColumn::make('id_register')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fakultas_id')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
