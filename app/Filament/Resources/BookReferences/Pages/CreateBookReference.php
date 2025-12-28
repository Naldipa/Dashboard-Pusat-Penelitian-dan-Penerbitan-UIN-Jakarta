<?php

namespace App\Filament\Resources\BookReferences\Pages;

use App\Filament\Resources\BookReferences\BookReferenceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookReference extends CreateRecord
{
    protected static string $resource = BookReferenceResource::class;
}
