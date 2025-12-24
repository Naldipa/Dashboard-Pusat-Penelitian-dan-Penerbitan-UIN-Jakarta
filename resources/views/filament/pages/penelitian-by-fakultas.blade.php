<x-filament-panels::page>
    <div
        x-data="{
            isImportOpen: false
        }"
        class="space-y-6"
    >

        {{-- 1. CONTROL BAR (Styled like a Filament Section) --}}
        <div class="rounded-xl bg-gray-300 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">

            {{-- Header Row --}}
            <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-4 dark:border-white/10 sm:flex-row sm:items-center sm:justify-between">

                {{-- LEFT: Import Trigger --}}
                <div class="flex items-center gap-3">
                    <x-filament::button
                        color="gray"
                        icon="heroicon-m-arrow-up-tray"
                        @click="isImportOpen = !isImportOpen"
                    >
                        Import Data
                    </x-filament::button>
                </div>

                {{-- RIGHT: View Controls --}}
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                    {{-- View Switcher --}}
                    <div class="flex rounded-lg shadow-sm ring-1 ring-gray-950/10 dark:ring-white/20">
                        <button
                            wire:click="$set('activeView', 'table')"
                            class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition first:rounded-l-lg last:rounded-r-lg border-r border-gray-950/10 dark:border-white/20 last:border-0
                            {{ $activeView === 'table'
                                ? 'bg-gray-50 text-primary-600 dark:bg-white/5 dark:text-primary-400'
                                : 'text-gray-700 hover:bg-gray-50 dark:bg-gray-900 dark:text-gray-200'
                            }}"
                        >
                            <x-filament::icon icon="heroicon-m-table-cells" class="h-4 w-4" />
                            <span>Tabel</span>
                        </button>
                        <button
                            wire:click="$set('activeView', 'chart')"
                            class="flex items-center gap-2 px-3 py-2 text-sm font-medium transition first:rounded-l-lg last:rounded-r-lg
                            {{ $activeView === 'chart'
                                ? 'bg-gray-50 text-primary-600 dark:bg-white/5 dark:text-primary-400'
                                : 'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/5'
                            }}"
                        >
                            <x-filament::icon icon="heroicon-m-chart-bar" class="h-4 w-4" />
                            <span>Grafik</span>
                        </button>
                    </div>

                    {{-- Year Selector --}}
                    <div class="flex items-center gap-2">
                        <x-filament::input.wrapper>
                            <x-filament::input.select wire:model.live="selectedYear">
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </x-filament::input.select>
                        </x-filament::input.wrapper>
                    </div>
                </div>
            </div>

            {{-- Import Form (Collapsible) --}}
            <div
                x-show="isImportOpen"
                x-collapse
                class="bg-gray-50 px-6 py-4 dark:bg-white/5"
                style="display: none;"
            >
                <form wire:submit="importData" class="flex flex-col gap-4 sm:flex-row">
                    <div class="flex-1">
                        <input type="file"
                            wire:model="fileExcel"
                            accept=".csv"
                            class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-primary-50 file:text-primary-700
                            hover:file:bg-primary-100
                            dark:file:bg-gray-800 dark:file:text-primary-400"
                        >
                        @error('fileExcel') <p class="mt-2 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p> @enderror
                    </div>
                    <x-filament::button type="submit">
                        Upload CSV
                    </x-filament::button>
                </form>
            </div>
        </div>

        {{-- 2. CONTENT AREA (Styled EXACTLY like a Filament Table) --}}

        {{-- VIEW: TABLE --}}
        @if ($activeView === 'table')
            <div class="divide-y divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Fakultas
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Total Dokumen
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/10 bg-white dark:bg-gray-900">
                            @foreach ($this->fakultas as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition duration-75">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('filament.admin.pages.penelitian-fakultas', ['fakultas' => $item['nama']]) }}"
                                           class="font-medium text-gray-950 dark:text-white hover:underline hover:text-primary-600 dark:hover:text-primary-400">
                                            {{ $item['nama'] }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ number_format($item['jumlah']) }}
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Footer Row --}}
                            <tr class="bg-gray-50 dark:bg-white/5 font-semibold">
                                <td class="px-6 py-4 text-gray-950 dark:text-white">Total Keseluruhan</td>
                                <td class="px-6 py-4 text-right text-primary-600 dark:text-primary-400">
                                    {{ number_format($this->totalKeseluruhan) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- VIEW: CHART --}}
        @if ($activeView === 'chart')
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Statistik Distribusi
                    </h3>
                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 dark:bg-white/10 dark:text-gray-400 dark:ring-white/20">
                        {{ $selectedYear }}
                    </span>
                </div>

                <div class="h-[500px] w-full">
                    @livewire(\App\Filament\Widgets\FakultasChart::class, [
                        'filterYear' => $selectedYear
                    ], key('chart-' . $selectedYear))
                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>
