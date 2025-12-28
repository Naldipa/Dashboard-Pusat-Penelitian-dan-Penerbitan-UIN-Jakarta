<x-filament-panels::page>
    <div class="flex justify-center">
        <div class="w-full max-w-7xl space-y-6">

            {{-- SECTION: UPLOAD CSV --}}
            <x-filament::section>
                <x-slot name="heading">
                    Import Data Tagihan Publikasi
                </x-slot>

                <x-slot name="description">
                    Upload file CSV untuk memperbarui data tagihan (Kolom: No_Reg, Judul, Ketua, Fakultas, dll).
                </x-slot>

                <form wire:submit="importData" class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">

                        <div class="flex-1 w-full">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Pilih File CSV
                            </label>

                            <div class="relative flex items-center gap-3">
                                <input type="file"
                                       wire:model="fileExcel"
                                       accept=".csv"
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-lg file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-primary-50 file:text-primary-700
                                              hover:file:bg-primary-100
                                              dark:file:bg-gray-800 dark:file:text-primary-400
                                              focus:outline-none" />

                                <div wire:loading wire:target="fileExcel">
                                    <x-filament::loading-indicator class="h-5 w-5 text-primary-500" />
                                </div>
                            </div>

                            @if ($fileExcel)
                                <p class="mt-2 text-xs text-primary-600">
                                    File siap: <strong>{{ $fileExcel->getClientOriginalName() }}</strong>
                                </p>
                            @endif

                            @error('fileExcel')
                                <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-6">
                            <x-filament::button type="submit" wire:target="importData">
                                <span wire:loading.remove wire:target="importData">
                                    Upload & Proses
                                </span>
                                <span wire:loading wire:target="importData">
                                    Memproses...
                                </span>
                            </x-filament::button>
                        </div>
                    </div>
                </form>
            </x-filament::section>

            {{-- SECTION: TABEL (Standard Filament Resource Table) --}}
            <div class="w-full">
                {{ $this->table }}
            </div>

        </div>
    </div>
</x-filament-panels::page>
