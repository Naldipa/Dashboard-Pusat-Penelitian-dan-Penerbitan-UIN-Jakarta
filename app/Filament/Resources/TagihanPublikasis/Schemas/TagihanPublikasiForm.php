<?php

namespace App\Filament\Resources\TagihanPublikasis\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class TagihanPublikasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Publikasi')
                    ->schema([
                        TextInput::make('no_reg')
                            ->label('No Registrasi')
                            ->maxLength(255),

                        TextInput::make('judul')
                            ->label('Judul Penelitian')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('ketua')
                            ->label('Ketua Peneliti')
                            ->maxLength(255),

                        TextInput::make('fakultas')
                            ->label('Fakultas')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Status Luaran')
                    ->schema([
                        Select::make('artikel_jurnal')
                            ->options([
                                'belum ada' => 'Belum Ada',
                                'ada' => 'Ada',
                            ])
                            ->default('belum ada'),

                        Select::make('proceeding')
                            ->options([
                                'belum ada' => 'Belum Ada',
                                'ada' => 'Ada',
                            ])
                            ->default('belum ada'),

                        Select::make('haki')
                            ->options([
                                'belum ada' => 'Belum Ada',
                                'ada' => 'Ada',
                            ])
                            ->default('belum ada'),

                        Select::make('buku')
                            ->options([
                                'belum ada' => 'Belum Ada',
                                'ada' => 'Ada',
                            ])
                            ->default('belum ada'),
                    ])
                    ->columns(2),
            ]);
    }
}
