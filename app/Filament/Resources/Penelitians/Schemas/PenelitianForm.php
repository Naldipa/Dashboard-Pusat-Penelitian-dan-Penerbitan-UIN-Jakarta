<?php

namespace App\Filament\Resources\Penelitians\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PenelitianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('judul')
                    ->required(),
                TextInput::make('nama_jurnal'),
                TextInput::make('klaster'),
                TextInput::make('biaya_insentif')
                    ->numeric(),
                TextInput::make('fakultas'),
                TextInput::make('penulis_utama')
                    ->required(),
                TextInput::make('anggota_penulis'),
                TextInput::make('tahun')
                    ->required()
                    ->numeric(),
                TextInput::make('status'),
                Textarea::make('abstrak')
                    ->columnSpanFull(),
                TextInput::make('file_path'),
                TextInput::make('id_register'),
                TextInput::make('fakultas_id')
                    ->numeric(),
            ]);
    }
}
