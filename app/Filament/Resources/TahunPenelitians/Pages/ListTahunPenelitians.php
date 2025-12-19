<?php

namespace App\Filament\Resources\TahunPenelitians\Pages;

use App\Filament\Resources\TahunPenelitians\TahunPenelitianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTahunPenelitians extends ListRecords
{
    protected static string $resource = TahunPenelitianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
