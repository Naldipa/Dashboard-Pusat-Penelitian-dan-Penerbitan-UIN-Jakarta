<x-filament-panels::page>
    <div
        x-data="{
            isImportOpen: false,
            init() {
                // Optional: Auto-open if there are errors
                @if($errors->any()) this.isImportOpen = true; @endif
            }
        }"
        class="flex justify-center"
    >
        <div class="w-full max-w-7xl space-y-6">

            {{-- 1. HEADER BAR (Unified Control Center) --}}
            <div class="rounded-xl bg-gray-900 ring-1 ring-white/10 shadow-xl overflow-hidden">

                {{-- Top Row: Title/Toggle + Controls --}}
                <div class="flex flex-col md:flex-row items-center justify-between p-4 gap-4 bg-white/5 backdrop-blur-sm">

                    {{-- Left: Import Toggle --}}
                    <button
                        @click="isImportOpen = !isImportOpen"
                        class="flex items-center gap-3 text-sm font-bold text-white hover:text-primary-400 transition-colors group"
                    >
                        <div class="p-2 rounded-lg bg-white/5 ring-1 ring-white/10 group-hover:bg-primary-500/20 group-hover:text-primary-400 transition-all">
                            <x-filament::icon
                                icon="heroicon-m-arrow-up-tray"
                                class="h-5 w-5 transition-transform duration-300"
                                x-bind:class="isImportOpen ? 'rotate-180' : ''"
                            />
                        </div>
                        <span>Import Data Penelitian</span>
                        <x-filament::icon
                            icon="heroicon-m-chevron-down"
                            class="h-4 w-4 text-gray-500 transition-transform duration-300"
                            x-bind:class="isImportOpen ? 'rotate-180' : ''"
                        />
                    </button>

                    {{-- Right: View Controls --}}
                    <div class="flex items-center gap-4 w-full md:w-auto justify-end">

                        {{-- View Switcher (Pill Style) --}}
                        <div class="flex items-center bg-black/40 rounded-lg p-1 ring-1 ring-white/5">
                            <button
                                wire:click="$set('activeView', 'table')"
                                class="flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-md transition-all
                                {{ $activeView === 'table'
                                    ? 'bg-gray-800 text-white shadow-sm ring-1 ring-white/10'
                                    : 'text-gray-500 hover:text-gray-300'
                                }}"
                            >
                                <x-filament::icon icon="heroicon-m-table-cells" class="h-4 w-4" />
                                <span class="hidden sm:inline">Tabel</span>
                            </button>
                            <button
                                wire:click="$set('activeView', 'chart')"
                                class="flex items-center gap-2 px-3 py-1.5 text-xs font-bold rounded-md transition-all
                                {{ $activeView === 'chart'
                                    ? 'bg-gray-800 text-white shadow-sm ring-1 ring-white/10'
                                    : 'text-gray-500 hover:text-gray-300'
                                }}"
                            >
                                <x-filament::icon icon="heroicon-m-chart-bar" class="h-4 w-4" />
                                <span class="hidden sm:inline">Grafik</span>
                            </button>
                        </div>

                        {{-- Year Filter --}}
                        <div class="flex items-center gap-3 bg-black/20 px-3 py-1.5 rounded-lg ring-1 ring-white/5">
                            <span class="text-xs font-medium text-gray-400">Periode:</span>
                            <select
                                wire:model.live="selectedYear"
                                class="bg-transparent border-0 p-0 pr-6 text-sm font-bold text-white focus:ring-0 cursor-pointer"
                            >
                                @foreach($years as $year)
                                    <option value="{{ $year }}" class="bg-gray-900">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Expandable Import Form --}}
                <div
                    x-show="isImportOpen"
                    x-collapse
                    class="border-t border-white/5 bg-black/20"
                >
                    <div class="p-6">
                        <form wire:submit="importData" class="space-y-4">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-400 mb-2">Upload File CSV</label>
                                    <input type="file"
                                        wire:model="fileExcel"
                                        accept=".csv"
                                        class="block w-full text-sm text-gray-400
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-xs file:font-bold
                                        file:bg-white/10 file:text-white
                                        hover:file:bg-white/20
                                        cursor-pointer bg-white/5 rounded-lg border border-white/10 focus:outline-none focus:ring-1 focus:ring-primary-500"
                                    >
                                    @error('fileExcel') <p class="text-xs text-danger-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="flex items-end">
                                    <x-filament::button type="submit" icon="heroicon-m-arrow-up-on-square">
                                        Proses Data
                                    </x-filament::button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- 2. CONTENT AREA --}}
            {{-- Using semi-transparent bg to let global background shine through --}}
            <div class="rounded-xl bg-gray-900/50 backdrop-blur-md ring-1 ring-white/10 shadow-2xl">

                @if ($activeView === 'table')
                    <div class="overflow-x-auto rounded-xl">
                        <table class="w-full text-left text-sm text-gray-400">
                            <thead>
                                <tr class="border-b border-white/5 bg-white/5 text-xs uppercase tracking-wider text-gray-300">
                                    <th class="px-6 py-4 font-semibold">Fakultas</th>
                                    <th class="px-6 py-4 text-right font-semibold">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($this->fakultas as $item)
                                    <tr class="group hover:bg-white/5 transition-colors duration-200">
                                        <td class="px-6 py-3.5">
                                            <a href="{{ route('filament.admin.pages.penelitian-fakultas', ['fakultas' => $item['nama']]) }}"
                                               class="flex items-center gap-3 text-gray-200 group-hover:text-primary-400 transition-colors">
                                                {{-- Minimalist Index/Avatar --}}
                                                <div class="h-1.5 w-1.5 rounded-full bg-gray-600 group-hover:bg-primary-500 transition-colors"></div>
                                                <span class="font-medium">{{ $item['nama'] }}</span>
                                            </a>
                                        </td>
                                        <td class="px-6 py-3.5 text-right font-mono text-gray-300 group-hover:text-white">
                                            {{ number_format($item['jumlah']) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-white/5 border-t border-white/10">
                                    <td class="px-6 py-4 text-xs font-bold text-white uppercase tracking-wider">Total Keseluruhan</td>
                                    <td class="px-6 py-4 text-right text-lg font-bold text-primary-400 font-mono">
                                        {{ number_format($this->totalKeseluruhan) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($activeView === 'chart')
                    <div class="p-6">
                        {{-- Chart container with height --}}
                        <div class="h-[500px] w-full">
                            @livewire(\App\Filament\Widgets\FakultasChart::class, [
                                'filterYear' => $selectedYear
                            ], key('chart-' . $selectedYear))
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-filament-panels::page>
