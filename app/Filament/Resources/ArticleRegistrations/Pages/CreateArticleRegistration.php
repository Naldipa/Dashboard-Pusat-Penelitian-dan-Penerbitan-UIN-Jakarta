<?php

namespace App\Filament\Resources\ArticleRegistrations\Pages;

use App\Filament\Resources\ArticleRegistrations\ArticleRegistrationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticleRegistration extends CreateRecord
{
    protected static string $resource = ArticleRegistrationResource::class;
}
