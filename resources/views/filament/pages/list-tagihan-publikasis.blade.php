<x-filament-panels::page>
    <div class="flex justify-center">
        <div class="w-full max-w-7xl space-y-6">

            {{-- IMPORT SECTION --}}
            <x-filament::section>
                <x-slot name="heading">Import Data Tagihan Publikasi</x-slot>
                <x-slot name="description">Upload file CSV untuk memperbarui data.</x-slot>

                <form wire:submit="importData" class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                        <div class="flex-1 w-full">
                            <input type="file" wire:model="fileExcel" accept=".csv"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-gray-800 dark:file:text-primary-400 focus:outline-none"
                            />
                            @error('fileExcel') <p class="mt-2 text-sm text-danger-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="pt-6">
                            <x-filament::button type="submit" wire:target="importData">
                                <span wire:loading.remove>Upload</span>
                                <span wire:loading>Memproses...</span>
                            </x-filament::button>
                        </div>
                    </div>
                </form>
            </x-filament::section>

            {{-- SUMMARY TABLE --}}
            <x-filament::section>
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-white/10">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-6 py-3">Kategori Publikasi</th>
                                <th class="px-6 py-3 text-right">Total Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">
                                        {{-- Link to Detail Page --}}
                                        <a href="{{ \App\Filament\Resources\TagihanPublikasis\TagihanPublikasiResource::getUrl('kategori', ['category' => $item['nama']]) }}"
                                           class="font-semibold text-white hover:text-primary-500 hover:underline underline-offset-4 decoration-primary-500/30">
                                            {{ $item['nama'] }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3 text-right font-bold">
                                        {{ number_format($item['jumlah']) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-primary-50 dark:bg-gray-800/50 border-t-2 border-primary-100 dark:border-gray-700">
                                <td class="text-white px-6 py-3 font-bold uppercase text-gray-900 dark:text-white">Total Keseluruhan</td>
                                <td class="px-6 py-3 text-right font-bold text-primary-700 dark:text-primary-400 text-lg">
                                    {{ number_format($totalRecords) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-filament::section>

        </div>
    </div>
</x-filament-panels::page>
