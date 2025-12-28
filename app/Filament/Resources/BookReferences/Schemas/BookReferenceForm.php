<?php

namespace App\Filament\Resources\BookReferences\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class BookReferenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama')
                    ->schema([
                        TextInput::make('judul')
                            ->label('Judul Buku')
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('penulis')
                            ->label('Penulis')
                            ->required(),

                        TextInput::make('editor')
                            ->label('Editor'),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi Buku')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Detail ISBN & Fisik')
                    ->schema([
                        TextInput::make('isbn')->label('ISBN'),
                        TextInput::make('e_isbn')->label('E-ISBN'),
                        TextInput::make('isbn_fk')->label('ISBN FK'),
                        TextInput::make('e_isbn_fk')->label('E-ISBN FK'),

                        TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric(),

                        TextInput::make('jumlah_halaman')
                            ->label('Jml Halaman')
                            ->numeric(),
                    ])->columns(2),

                Section::make('File & Status')
                    ->schema([
                        FileUpload::make('cover')
                            ->label('Cover Buku')
                            ->image()
                            ->directory('covers'),

                        FileUpload::make('naskah_link')
                            ->label('File Naskah (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('naskahs'),

                        TextInput::make('status')
                            ->label('Status')
                            ->default('Done'),

                        TextInput::make('keterangan')
                            ->label('Keterangan'),
                    ])->columns(2),
            ]);
    }
}
