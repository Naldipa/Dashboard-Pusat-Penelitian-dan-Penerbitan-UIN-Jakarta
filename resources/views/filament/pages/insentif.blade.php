<x-filament-panels::page>
    <div class="flex justify-center">
        <div class="w-full max-w-7xl space-y-6">

            {{-- SECTION: UPLOAD CSV --}}
            <x-filament::section>
                <x-slot name="heading">
                    Import Data Insentif
                </x-slot>

                <x-slot name="description">
                    Upload file CSV untuk memperbarui data insentif (Kolom: Nama, Judul, Klaster, Nominal).
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
                                <p class="mt-2 text-xs text-primary-600 dark:text-primary-400">
                                    File siap: <strong>{{ $fileExcel->getClientOriginalName() }}</strong>
                                </p>
                            @endif
                            @error('fileExcel')
                                <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-6">
                            <x-filament::button type="submit" wire:target="importData">
                                <span wire:loading.remove wire:target="importData">Upload & Proses</span>
                                <span wire:loading wire:target="importData">Memproses...</span>
                            </x-filament::button>
                        </div>
                    </div>
                </form>
            </x-filament::section>

            {{-- SECTION: CONTROLS (View Toggle + Year Filter) --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-900 p-2 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 sticky top-4 z-10 backdrop-blur-sm bg-opacity-90">

                {{-- A. View Toggle --}}
                <div class="bg-gray-100 dark:bg-gray-800 p-1.5 rounded-lg flex items-center w-full sm:w-auto">
                    <button
                        wire:click="$set('activeView', 'table')"
                        class="flex-1 sm:flex-none px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 flex items-center justify-center gap-2
                        {{ $activeView === 'table'
                            ? 'bg-white text-primary-600 shadow-sm ring-1 ring-gray-200 dark:bg-gray-700 dark:text-primary-400 dark:ring-gray-600'
                            : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'
                        }}"
                    >
                        <x-filament::icon icon="heroicon-m-table-cells" class="h-4 w-4" />
                        <span>Tabel Data</span>
                    </button>
                    <button
                        wire:click="$set('activeView', 'chart')"
                        class="flex-1 sm:flex-none px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 flex items-center justify-center gap-2
                        {{ $activeView === 'chart'
                            ? 'bg-white text-primary-600 shadow-sm ring-1 ring-gray-200 dark:bg-gray-700 dark:text-primary-400 dark:ring-gray-600'
                            : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'
                        }}"
                    >
                        <x-filament::icon icon="heroicon-m-chart-bar" class="h-4 w-4" />
                        <span>Visualisasi</span>
                    </button>
                </div>

                {{-- B. Year Filter --}}
                <div class="flex items-center gap-3 w-full sm:w-auto bg-gray-50 dark:bg-gray-800 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700">
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <x-filament::icon icon="heroicon-m-calendar" class="h-4 w-4" />
                        Periode
                    </label>
                    <div class="h-4 w-px bg-gray-300 dark:bg-gray-600"></div>
                    <select
                        wire:model.live="selectedYear"
                        class="block w-full sm:w-32 bg-transparent border-0 py-1.5 pl-2 pr-8 text-sm font-semibold text-gray-900 focus:ring-0 dark:text-white cursor-pointer hover:text-primary-600 transition-colors"
                    >
                        @foreach($years as $year)
                            <option value="{{ $year }}" class="dark:bg-gray-900">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- VIEW A: TABLE --}}
            @if ($activeView === 'table')
                <x-filament::section>
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-white/10">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                <tr>
                                    <th class="px-6 py-3">Klaster</th>
                                    <th class="px-6 py-3 text-right">Total Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($klaster as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">
                                            {{-- Assuming you have a detail page for Insentif Klaster --}}
                                            <a href="{{ \App\Filament\Pages\InsentifData::getUrl(['klaster' => $item['nama']]) }}"
                                               class="font-semibold text-primary-600 hover:text-primary-500 hover:underline underline-offset-4 decoration-primary-500/30">
                                                {{ $item['nama'] }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-3 text-right font-bold text-gray-900 dark:text-white">
                                            {{ number_format($item['jumlah']) }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr class="bg-primary-50 dark:bg-gray-800/50 border-t-2 border-primary-100 dark:border-gray-700">
                                    <td class="px-6 py-3 font-bold uppercase text-gray-900 dark:text-white">
                                        Total Keseluruhan
                                    </td>
                                    <td class="px-6 py-3 text-right font-bold text-primary-700 dark:text-primary-400 text-base">
                                        {{ number_format($totalKeseluruhan) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </x-filament::section>
            @endif

            {{-- VIEW B: CHART --}}
            @if ($activeView === 'chart')
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-700">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-filament::icon icon="heroicon-m-presentation-chart-bar" class="h-5 w-5 text-primary-500" />
                            Statistik Distribusi Klaster
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Visualisasi data insentif berdasarkan klaster tahun {{ $selectedYear }}.
                        </p>
                    </div>

                    <div class="h-[500px] w-full">
                        @livewire(\App\Filament\Widgets\InsentifKlasterChart::class, [
                            'filterYear' => $selectedYear
                        ], key('chart-' . $selectedYear))
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-filament-panels::page>
