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
            while (($row = fgetcsv($handle, 5000, ',')) !== false) {
                if (stripos(($row[0] ?? ''), 'Judul') !== false) {
                    continue;
                }

                if (empty(trim($row[0] ?? ''))) {
                    continue;
                }

                BookReference::create([
                    'judul'          => $row[0] ?? 'Untitled',
                    'penulis'          => $row[1] ?? null,
                    'isbn'         => $row[2] ?? null,
                    'e_isbn'         => $row[3] ?? null,
                    'editor'         => $row[4] ?? null,
                    'deskripsi'      => $row[5] ?? null,
                    'tahun'          => isset($row[6]) && is_numeric($row[6]) ? (int) $row[6] : null,
                    'naskah_link'    => $row[7] ?? null,
                    'cover'          => $row[8] ?? null,
                    'jumlah_halaman' => isset($row[9]) && is_numeric($row[9]) ? (int) $row[9] : 0,
                    'status'         => !empty($row[10]) ? $row[10] : 'Draft',
                    'keterangan'     => $row[11] ?? null,
                ]);

                $count++;
            }

            DB::commit();
            fclose($handle);
            $this->reset(['fileExcel', 'isImportOpen']);

            // Refresh table (if using Livewire traits)
            // $this->dispatch('refresh-table');

            Notification::make()->title("Berhasil import {$count} buku.")->success()->send();

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
        }
    }
}
