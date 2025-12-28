<?php

namespace App\Filament\Resources\TagihanPublikasis;

use App\Filament\Resources\TagihanPublikasis\Pages\CreateTagihanPublikasi;
use App\Filament\Resources\TagihanPublikasis\Pages\EditTagihanPublikasi;
use App\Filament\Resources\TagihanPublikasis\Pages\ListTagihanPublikasis;
use App\Filament\Resources\TagihanPublikasis\Schemas\TagihanPublikasiForm;
use App\Filament\Resources\TagihanPublikasis\Tables\TagihanPublikasiTable;
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

    protected static ?string $recordTitleAttribute = 'TagihanPublikasi';

    public static function form(Schema $schema): Schema
    {
        return TagihanPublikasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TagihanPublikasiTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTagihanPublikasis::route('/'),
            'create' => CreateTagihanPublikasi::route('/create'),
            'edit' => EditTagihanPublikasi::route('/{record}/edit'),
        ];
    }
}
