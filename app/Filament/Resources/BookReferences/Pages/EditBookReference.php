<?php

namespace App\Filament\Resources\BookReferences\Pages;

use App\Filament\Resources\BookReferences\BookReferenceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookReference extends EditRecord
{
    protected static string $resource = BookReferenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
