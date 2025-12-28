<?php

namespace App\Filament\Resources\TagihanPublikasis\Pages;

use App\Filament\Resources\TagihanPublikasis\TagihanPublikasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTagihanPublikasi extends EditRecord
{
    protected static string $resource = TagihanPublikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
