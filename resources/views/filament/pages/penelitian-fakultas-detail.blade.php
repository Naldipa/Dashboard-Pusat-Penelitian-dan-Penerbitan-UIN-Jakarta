<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                {{ $fakultas }}
            </h2>
            <x-filament::button
                color="gray"
                tag="a"
                href="{{ \App\Filament\Pages\PenelitianByFakultas::getUrl() }}"
                icon="heroicon-m-chevron-left"
            >
                Kembali
            </x-filament::button>
        </div>

        {{--
           THIS IS THE MAGIC LINE.
           It renders the search bar, the table, pagination,
           and the Edit Modals all automatically.
        --}}
        {{ $this->table }}

    </div>
</x-filament-panels::page>
