<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header with Back Button --}}
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                Kategori: {{ $klaster }}
            </h2>

            <x-filament::button
                color="gray"
                tag="a"
                {{-- Link back to the main Insentif Data page --}}
                href="{{ \App\Filament\Pages\InsentifData::getUrl() }}"
                icon="heroicon-m-chevron-left"
            >
                Kembali
            </x-filament::button>
        </div>

        {{-- Render the Filtered Table --}}
        {{ $this->table }}

    </div>
</x-filament-panels::page>
