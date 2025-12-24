<?php

namespace App\Filament\Pages;

use App\Models\TagihanPublikasi;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class TagihanPublikasiPage extends Page implements HasTable
{
    use InteractsWithTable;
    use WithFileUploads;

    protected static ?string $navigationLabel = 'Tagihan Publikasi';
    protected static ?string $title = 'Data Tagihan Publikasi';
    protected static ?string $slug = 'tagihan-publikasi';

    protected string $view = 'filament.pages.tagihan-publikasi';

    public $fileExcel;
    public $isImportOpen = false;

    public function table(Table $table): Table
    {
        return $table
            ->query(TagihanPublikasi::query()->latest())
            ->columns([
                TextColumn::make('no_reg')
                    ->label('No. Reg')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('judul')
                    ->wrap()
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('ketua')
                    ->label('Ketua Peneliti')
                    ->searchable(),

                TextColumn::make('fakultas')
                    ->searchable()
                    ->toggleable(),

                // Status Columns with Color Logic
                TextColumn::make('artikel_jurnal')
                    ->label('Jurnal')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'belum ada' ? 'gray' : 'success'),

                TextColumn::make('proceeding')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'belum ada' ? 'gray' : 'success')
                    ->toggleable(),

                TextColumn::make('haki')
                    ->label('HAKI')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'belum ada' ? 'gray' : 'success')
                    ->toggleable(),

                TextColumn::make('buku')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'belum ada' ? 'gray' : 'success')
                    ->toggleable(),
            ]);
    }

    public function importData()
    {
        $this->validate([
            'fileExcel' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($this->fileExcel->getRealPath(), 'r');
        $header = null;
        $count = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                // Determine Header
                if ($header === null) {
                    // Convert headers to lowercase/slug for easier matching
                    // Expecting: No_Reg, Judul, Ketua, Fakultas, Artikel_Jurnal, Proceeding, HAKI, Buku
                    $header = array_map(fn($h) => Str::snake(Str::lower(trim($h))), $row);
                    continue;
                }

                $data = [];
                foreach ($row as $i => $value) {
                    $key = $header[$i] ?? null;
                    if ($key) $data[$key] = trim($value);
                }

                // Skip if Title is missing
                if (empty($data['judul'])) continue;

                // Create Record
                TagihanPublikasi::updateOrCreate(
                    ['no_reg' => $data['no_reg'] ?? null], // Use No_Reg to prevent duplicates
                    [
                        'judul'          => $data['judul'],
                        'ketua'          => $data['ketua'] ?? '-',
                        'fakultas'       => $data['fakultas'] ?? null,
                        'artikel_jurnal' => $data['artikel_jurnal'] ?? 'belum ada',
                        'proceeding'     => $data['proceeding'] ?? 'belum ada',
                        'haki'           => $data['haki'] ?? 'belum ada',
                        'buku'           => $data['buku'] ?? 'belum ada',
                    ]
                );

                $count++;
            }

            DB::commit();
            fclose($handle);
            $this->reset(['fileExcel', 'isImportOpen']);

            Notification::make()->title("Import Berhasil: {$count} data")->success()->send();

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            Notification::make()->title('Error')->body($e->getMessage())->danger()->send();
        }
    }
}
