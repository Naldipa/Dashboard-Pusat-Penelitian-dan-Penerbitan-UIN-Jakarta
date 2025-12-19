<?php

namespace App\Filament\Resources\TahunPenelitians;

use App\Filament\Resources\TahunPenelitians\Pages\CreateTahunPenelitian;
use App\Filament\Resources\TahunPenelitians\Pages\EditTahunPenelitian;
use App\Filament\Resources\TahunPenelitians\Pages\ListTahunPenelitians;
use App\Filament\Resources\TahunPenelitians\Schemas\TahunPenelitianForm;
use App\Filament\Resources\TahunPenelitians\Tables\TahunPenelitiansTable;
use App\Models\TahunPenelitian;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TahunPenelitianResource extends Resource
{
    protected static ?string $model = TahunPenelitian::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'TahunPenelitian';

    public static function form(Schema $schema): Schema
    {
        return TahunPenelitianForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TahunPenelitiansTable::configure($table);
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
            'index' => ListTahunPenelitians::route('/'),
            'create' => CreateTahunPenelitian::route('/create'),
            'edit' => EditTahunPenelitian::route('/{record}/edit'),
        ];
    }
}
