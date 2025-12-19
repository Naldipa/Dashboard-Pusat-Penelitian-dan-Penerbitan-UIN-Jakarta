<?php

namespace App\Filament\Resources\TahunPenelitians\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class TahunPenelitianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Fakultas')
                    ->schema([
                        TextInput::make('tahun')
                            ->label('Tahun Penelitian')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                        Select::make('isActive')
                            ->label('Aktif')
                            ->options([
                                0 => 'Non Aktif',
                                1 => 'Aktif',
                            ])
                            ->default(0)
                            ->required(),
                    ])
                    ->columns(2)
            ]);
    }
}
