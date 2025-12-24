<x-filament-panels::page>
    <div
        x-data="{
            isImportOpen: @entangle('isImportOpen')
        }"
        class="flex justify-center"
    >
        <div class="w-full max-w-7xl">

            {{-- MAIN CONTAINER --}}
            <div class="overflow-hidden rounded-xl border border-gray-800 bg-[#18181b] shadow-sm">

                {{-- 1. HEADER BAR --}}
                <div class="flex flex-col border-b border-gray-800 bg-[#18181b] px-4 py-3 sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-bold text-white tracking-tight">Rekapitulasi Artikel</h2>
                    </div>

                    {{-- Import Toggle --}}
                    <button
                        @click="isImportOpen = !isImportOpen"
                        class="group flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-bold text-white hover:bg-primary-500 transition-colors"
                    >
                        <x-filament::icon
                            icon="heroicon-m-arrow-up-tray"
                            class="h-4 w-4 text-white"
                        />
                        <span>Import CSV</span>
                        <x-filament::icon
                            icon="heroicon-m-chevron-down"
                            class="h-3 w-3 text-white/70 transition-transform duration-200"
                            x-bind:class="isImportOpen ? 'rotate-180' : ''"
                        />
                    </button>
                </div>

                {{-- 2. IMPORT FORM (Collapsible) --}}
                <div
                    x-show="isImportOpen"
                    x-collapse
                    class="border-b border-gray-800 bg-[#121212]"
                    style="display: none;"
                >
                    <div class="p-6">
                        <form wire:submit="importData">
                            <div class="mb-2 text-sm text-gray-400">
                                Format Kolom CSV: <code class="text-primary-400">Nama Lengkap, Fakultas, Judul Artikel Lengkap, Jumlah (Rp)</code>
                            </div>
                            <div class="flex max-w-2xl flex-col gap-4 sm:flex-row">
                                <input type="file"
                                    wire:model="fileExcel"
                                    accept=".csv"
                                    class="block w-full rounded-lg border border-gray-700 bg-gray-800 text-sm text-gray-400
                                    file:mr-4 file:border-0 file:bg-gray-700 file:px-4 file:py-2.5
                                    file:text-xs file:font-semibold file:text-white
                                    hover:file:bg-gray-600 focus:outline-none cursor-pointer"
                                >
                                <x-filament::button type="submit" wire:target="importData">
                                    <span wire:loading.remove wire:target="importData">Proses Import</span>
                                    <span wire:loading wire:target="importData">Memproses...</span>
                                </x-filament::button>
                            </div>
                            @error('fileExcel') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
                        </form>
                    </div>
                </div>

                {{-- 3. SUMMARY TABLE --}}
                <div class="bg-[#18181b]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-400">
                            <thead class="bg-[#202024] text-xs uppercase text-gray-400">
                                <tr>
                                    <th class="px-6 py-4 font-semibold tracking-wider">Fakultas</th>
                                    <th class="px-6 py-4 text-right font-semibold tracking-wider">Total Dana</th>
                                    <th class="px-6 py-4 text-right font-semibold tracking-wider">Total Artikel</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800/50 text-gray-300">
                                @foreach ($fakultasSummary as $item)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 font-medium text-white">
                                            {{-- Link to Detail Page --}}
                                            <a href="{{ \App\Filament\Pages\ArticleRegistrationDetail::getUrl(['fakultas' => $item['nama']]) }}"
                                               class="hover:text-primary-400 hover:underline decoration-primary-500/30 underline-offset-4 cursor-pointer">
                                                {{ $item['nama'] }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-right font-mono text-gray-400">
                                            Rp {{ number_format($item['total_rp'], 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right font-mono font-bold text-white">
                                            {{ number_format($item['jumlah']) }}
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- Total Row --}}
                                <tr class="bg-[#202024] border-t border-gray-800">
                                    <td class="px-6 py-4 text-xs font-bold uppercase text-white">Total Keseluruhan</td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-primary-400 font-mono">
                                        Rp {{ number_format($totalUang, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-lg font-bold text-primary-400 font-mono">
                                        {{ number_format($totalKeseluruhan) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
