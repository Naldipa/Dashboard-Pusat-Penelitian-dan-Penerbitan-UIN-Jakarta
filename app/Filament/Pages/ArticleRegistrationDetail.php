<?php

namespace App\Filament\Pages;

use App\Models\ArticleRegistration;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Http\Request;

class ArticleRegistrationDetail extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'Detail Registrasi Artikel';
    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.article-registration-detail';

    public string $fakultas = '';
    protected $queryString = ['fakultas'];

    public function mount(Request $request): void
    {
        $this->fakultas = $request->query('fakultas', '');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ArticleRegistration::query()
                    ->where('fakultas', $this->fakultas)
                    ->latest()
            )
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('judul')
                    ->label('Judul Artikel')
                    ->wrap()
                    ->limit(60)
                    ->searchable(),

                TextColumn::make('jumlah_rp')
                    ->label('Insentif')
                    ->money('IDR')
                    ->sortable(),
            ]);
    }
}
