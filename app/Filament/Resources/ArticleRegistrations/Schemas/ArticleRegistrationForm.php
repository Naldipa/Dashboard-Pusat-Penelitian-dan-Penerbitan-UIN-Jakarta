<?php

namespace App\Filament\Resources\ArticleRegistrations\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class ArticleRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Artikel')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('fakultas')
                            ->label('Fakultas')
                            ->maxLength(255),

                        TextInput::make('judul')
                            ->label('Judul Artikel')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('jumlah_rp')
                            ->label('Jumlah (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
