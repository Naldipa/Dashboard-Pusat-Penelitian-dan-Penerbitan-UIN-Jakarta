<?php

namespace App\Filament\Resources\ArticleRegistrations;

use App\Filament\Resources\ArticleRegistrations\Pages\CreateArticleRegistration;
use App\Filament\Resources\ArticleRegistrations\Pages\EditArticleRegistration;
use App\Filament\Resources\ArticleRegistrations\Pages\ListArticleRegistrations;
use App\Filament\Resources\ArticleRegistrations\Schemas\ArticleRegistrationForm;
use App\Filament\Resources\ArticleRegistrations\Tables\ArticleRegistrationsTable;
use App\Models\ArticleRegistration;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ArticleRegistrationResource extends Resource
{
    protected static ?string $model = ArticleRegistration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = "Artikel";
    protected static ?string $navigationLabel = 'Registrasi Artikel';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return ArticleRegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ArticleRegistrationsTable::configure($table);
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
            'index' => ListArticleRegistrations::route('/'),
            'create' => CreateArticleRegistration::route('/create'),
            'edit' => EditArticleRegistration::route('/{record}/edit'),
        ];
    }
}
