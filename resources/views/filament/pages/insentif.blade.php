<x-filament-panels::page>
    <div class="flex justify-center">
        <div class="w-full max-w-4xl space-y-6">

            {{-- SECTION: UPLOAD CSV --}}
            <x-filament::section>
                <x-slot name="heading">
                    Import Data Insentif
                </x-slot>

                <x-slot name="description">
                    Upload file CSV untuk memperbarui rekap insentif penelitian.
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

            {{-- SECTION: TABEL --}}
            <x-filament::section>
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-white/10">
                    <table class="w-full text-sm text-left text-gray-200 dark:text-gray-300">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3">Klaster</th>
                                <th class="px-6 py-3 text-right">Total Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($klaster as $item)
                                <tr class="border-b dark:border-gray-700 px-6">
                                    <td class="px-6 py-3 font-medium text-gray-200 dark:text-white">
                                        {{ $item['nama'] }}
                                    </td>
                                    <td class="px-6 py-3 text-right font-semibold">
                                        {{ $item['jumlah'] }}
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="bg-primary-50 dark:bg-gray-800/50 border-t-2">
                                <td class="px-6 py-3 font-bold uppercase">
                                    Total Keseluruhan
                                </td>
                                <td class="px-6 py-3 text-right font-bold text-primary-700">
                                    {{ $totalKeseluruhan }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-filament::button color="gray" tag="a"
                        href="{{ \App\Filament\Pages\DashboardRiset::getUrl() }}">
                        Kembali ke Dashboard
                    </x-filament::button>
                </div>
            </x-filament::section>

        </div>
    </div>
</x-filament-panels::page>
