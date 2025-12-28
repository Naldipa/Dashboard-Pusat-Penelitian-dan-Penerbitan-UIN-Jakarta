<?php

namespace App\Filament\Resources\ArticleRegistrations\Pages;

use App\Filament\Resources\ArticleRegistrations\ArticleRegistrationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArticleRegistration extends EditRecord
{
    protected static string $resource = ArticleRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
