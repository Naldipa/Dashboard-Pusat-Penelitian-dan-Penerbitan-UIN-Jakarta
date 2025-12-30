<?php

namespace App\Filament\Resources\TagihanPublikasis\Pages;

use App\Filament\Resources\TagihanPublikasis\TagihanPublikasiResource;
use App\Filament\Resources\TagihanPublikasis\Tables\TagihanPublikasisTable;
use App\Models\TagihanPublikasi;
use Filament\Resources\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Action;
use UnitEnum;

class TagihanPublikasiDetail extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = TagihanPublikasiResource::class;

    protected static string|UnitEnum|null $navigationGroup = "Publikasi";
    protected static ?string $navigationLabel = 'Tagihan Publikasi Detail (Kategori)';

    protected string $view = 'filament.pages.tagihan-publikasi-detail';

    public $category;

    public function mount($category): void
    {
        $this->category = $category === 'Tanpa Kategori' ? '' : $category;
    }

    public function getTitle(): string
    {
        return $this->category ?: 'Tanpa Kategori';
    }

    public function table(Table $table): Table
    {
        // 1. Get the base configuration from your existing table class
        $table = TagihanPublikasisTable::configure($table);

        // 2. Apply the filter query
        return $table->query(
            TagihanPublikasi::query()
                ->where('kategori', $this->category)
                ->latest()
        );
    }
}
