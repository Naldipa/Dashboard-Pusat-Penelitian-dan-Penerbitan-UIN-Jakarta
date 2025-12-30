<?php

namespace App\Filament\Resources\BookReferences;

use App\Filament\Resources\BookReferences\Pages\CreateBookReference;
use App\Filament\Resources\BookReferences\Pages\EditBookReference;
use App\Filament\Resources\BookReferences\Pages\ListBookReferences;
use App\Filament\Resources\BookReferences\Schemas\BookReferenceForm;
use App\Filament\Resources\BookReferences\Tables\BookReferencesTable;
use App\Models\BookReference;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;
use Filament\Support\Icons\Heroicon;

class BookReferenceResource extends Resource
{
    protected static ?string $model = BookReference::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;

    protected static string|UnitEnum|null $navigationGroup = "Buku Referensi";

    protected static ?string $navigationLabel = 'Referensi Buku';

    protected static ?string $slug = 'referensi-buku';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return BookReferenceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookReferencesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookReferences::route('/'),
            'create' => CreateBookReference::route('/create'),
            'edit' => EditBookReference::route('/{record}/edit'),
        ];
    }
}
