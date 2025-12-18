<?php

namespace App\Filament\Resources\Fakultas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class FakultasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Fakultas')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Fakultas')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                        TextInput::make('kode')
                            ->label('Kode Singkatan')
                            ->placeholder('Ex: FST')
                            ->required()
                            ->maxLength(10),

                        Select::make('warna')
                            ->label('Warna Badge')
                            ->options([
                                'primary' => 'Primary (Blue)',
                                'danger' => 'Red',
                                'warning' => 'Yellow',
                                'success' => 'Green',
                                'info' => 'Cyan',
                                'gray' => 'Gray',
                            ])
                            ->default('primary')
                            ->required(),
                    ])
                    ->columns(2)
            ]);
    }
}
