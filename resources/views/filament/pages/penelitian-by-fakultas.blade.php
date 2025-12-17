<x-filament-panels::page>
    <div class="flex justify-center">
        <div class="w-full max-w-4xl space-y-6">

            {{-- 1. USE FILAMENT SECTION (Matches Theme & Dark Mode automatically) --}}
            <x-filament::section>
                <x-slot name="heading">
                    Import Data Penelitian
                </x-slot>

                <x-slot name="description">
                    Upload file CSV untuk memperbarui data rekapitulasi.
                </x-slot>

                <form wire:submit="importData" class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">

                        {{-- Custom File Input Wrapper --}}
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                                Pilih File CSV
                            </label>

                            <div class="relative flex items-center gap-3">
                                <input type="file"
                                       wire:model="fileExcel"
                                       id="file_upload"
                                       accept=".csv"
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-lg file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-primary-50 file:text-primary-700
                                              hover:file:bg-primary-100
                                              dark:file:bg-gray-800 dark:file:text-primary-400
                                              focus:outline-none"
                                />

                                {{-- Loading Spinner --}}
                                <div wire:loading wire:target="fileExcel">
                                    <x-filament::loading-indicator class="h-5 w-5 text-primary-500" />
                                </div>
                            </div>

                            {{-- UX FIX: Explicitly show the filename if uploaded --}}
                            @if ($fileExcel)
                                <div class="mt-2 text-xs text-primary-600 dark:text-primary-400 flex items-center gap-1">
                                    <x-filament::icon icon="heroicon-m-document-check" class="h-4 w-4" />
                                    File siap: <strong>{{ $fileExcel->getClientOriginalName() }}</strong>
                                </div>
                            @endif

                            @error('fileExcel')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Action Button using Filament Component --}}
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

            {{-- 2. DATA TABLE SECTION --}}
            <x-filament::section>
                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-white/10">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">Fakultas</th>
                                <th scope="col" class="px-6 py-3 text-right">Total Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->fakultas as $index => $item)
                                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                    <td class="px-6 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{-- Link using Primary Color --}}
                                        <a href="{{ route('filament.admin.pages.penelitian-fakultas', ['fakultas' => $item['nama']]) }}"
                                           class="hover:text-primary-600 hover:underline decoration-primary-500/30 underline-offset-4">
                                            {{ $item['nama'] }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $item['jumlah'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- TOTAL ROW --}}
                            <tr class="bg-primary-50 dark:bg-gray-800/50 border-t-2 border-primary-100 dark:border-gray-700">
                                <td class="px-6 py-3 font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                                    Total Keseluruhan
                                </td>
                                <td class="px-6 py-3 text-right font-bold text-primary-700 dark:text-primary-400 text-base">
                                    {{ $this->totalKeseluruhan }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Footer / Close Button --}}
                <div class="mt-6 flex justify-end">
                    <x-filament::button color="gray" tag="a" href="{{ \App\Filament\Pages\DashboardRiset::getUrl() }}">
                        Kembali ke Dashboard
                    </x-filament::button>
                </div>
            </x-filament::section>

        </div>
    </div>
</x-filament-panels::page>
