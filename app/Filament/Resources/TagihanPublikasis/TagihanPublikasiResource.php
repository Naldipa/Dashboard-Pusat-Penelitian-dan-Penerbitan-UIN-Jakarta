<?php

namespace App\Filament\Resources\TagihanPublikasis;

use App\Filament\Resources\TagihanPublikasis\Pages\ListTagihanPublikasis;
use App\Filament\Resources\TagihanPublikasis\Pages\TagihanPublikasiDetail; // New Detail Page
use App\Models\TagihanPublikasi;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TagihanPublikasiResource extends Resource
{
    protected static ?string $model = TagihanPublikasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = "Publikasi";
    protected static ?string $navigationLabel = 'Tagihan Publikasi';
    protected static ?string $slug = 'tagihan-publikasi';

    public static function table(Table $table): Table
    {
        // Table logic is now moved to the specific pages
        return $table;
    }

    public static function getPages(): array
    {
        return [
            // Index shows the Summary of Categories
            'index' => ListTagihanPublikasis::route('/'),

            // Detail shows the records for a specific category
            // We use a custom slug parameter {category}
            'kategori' => TagihanPublikasiDetail::route('/kategori/{category}'),
        ];
    }
}
