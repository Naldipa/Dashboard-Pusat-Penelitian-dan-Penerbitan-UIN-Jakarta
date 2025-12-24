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
                        <h2 class="text-lg font-bold text-white tracking-tight">Data Tagihan Publikasi</h2>
                        <span class="rounded bg-gray-800 px-2 py-0.5 text-xs text-gray-400 border border-gray-700">
                            {{ \App\Models\TagihanPublikasi::count() }} Items
                        </span>
                    </div>

                    {{-- Right: Import Toggle --}}
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
                                Pastikan kolom CSV: <code class="text-primary-400">No_Reg, Judul, Ketua, Fakultas, Artikel_Jurnal, Proceeding, HAKI, Buku</code>
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

                {{-- 3. CONTENT AREA (The Table) --}}
                <div class="bg-[#18181b] p-4">
                    {{ $this->table }}
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
