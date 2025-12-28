<?php

namespace App\Filament\Resources\Penelitians;

use App\Filament\Resources\Penelitians\Pages\ListPenelitians;
use App\Filament\Resources\Penelitians\Pages\PenelitianFakultasDetail;
use App\Models\Penelitian;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PenelitianResource extends Resource
{
    protected static ?string $model = Penelitian::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = "Penelitian";
    protected static ?string $navigationLabel = 'Penelitian';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenelitians::route('/'),

            'fakultas' => PenelitianFakultasDetail::route('/fakultas/{fakultas}'),
        ];
    }
}
