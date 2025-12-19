<?php

namespace App\Filament\Resources\TahunPenelitians\Pages;

use App\Filament\Resources\TahunPenelitians\TahunPenelitianResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTahunPenelitian extends EditRecord
{
    protected static string $resource = TahunPenelitianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
