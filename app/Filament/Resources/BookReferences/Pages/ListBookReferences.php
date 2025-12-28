<?php

namespace App\Filament\Resources\BookReferences\Pages;

use App\Filament\Resources\BookReferences\BookReferenceResource;
use App\Models\BookReference;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class ListBookReferences extends ListRecords
{
    use WithFileUploads;

    protected static string $resource = BookReferenceResource::class;

    protected string $view = 'filament.pages.list-book-reference';

    public $fileExcel;
    public $isImportOpen = false;

    public function importData()
    {
        $this->validate([
            'fileExcel' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($this->fileExcel->getRealPath(), 'r');
        $count = 0;

        DB::beginTransaction();
        try {
            // Mapping based on your example data order:
            // 0:Judul, 1:Penulis, 2:ISBN, 3:E-ISBN, 4:ISBN FK, 5:E-ISBN FK,
            // 6:Editor, 7:Deskripsi, 8:Tahun, 9:Naskah, 10:Cover, 11:Halaman,
            // 12:Status, 13:Keterangan

            while (($row = fgetcsv($handle, 2000, ',')) !== false) {
                // Skip header row if it exists (basic check if first col is 'Judul Buku')
                if (strtolower(trim($row[0] ?? '')) === 'judul buku') {
                    continue;
                }

                BookReference::create([
                    'judul'          => $row[0] ?? 'Untitled',
                    'penulis'        => $row[1] ?? '-',
                    'isbn'           => $row[2] ?? null,
                    'e_isbn'         => $row[3] ?? null,
                    'isbn_fk'        => $row[4] ?? null,
                    'e_isbn_fk'      => $row[5] ?? null,
                    'editor'         => $row[6] ?? null,
                    'deskripsi'      => $row[7] ?? null,
                    'tahun'          => isset($row[8]) ? (int) $row[8] : null,
                    'naskah_link'    => $row[9] ?? null,
                    'cover'          => $row[10] ?? null,
                    'jumlah_halaman' => isset($row[11]) ? (int) $row[11] : 0,
                    'status'         => $row[12] ?? 'Draft',
                    'keterangan'     => $row[13] ?? null,
                ]);

                $count++;
            }

            DB::commit();
            fclose($handle);
            $this->reset(['fileExcel', 'isImportOpen']);

            // Refresh table
            $this->dispatch('refresh-table');

            Notification::make()->title("Berhasil import {$count} buku.")->success()->send();

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
        }
    }
}
