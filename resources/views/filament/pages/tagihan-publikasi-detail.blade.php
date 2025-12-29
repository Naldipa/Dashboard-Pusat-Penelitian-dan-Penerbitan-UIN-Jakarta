<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">
                {{-- Title is handled by getTitle() in class, but we can add context here if needed --}}
            </h2>
            <x-filament::button
                color="gray"
                tag="a"
                href="{{ \App\Filament\Resources\TagihanPublikasis\TagihanPublikasiResource::getUrl('index') }}"
                icon="heroicon-m-chevron-left"
            >
                Kembali ke Rekapitulasi
            </x-filament::button>
        </div>

        {{-- Render the Filament Table --}}
        {{ $this->table }}

    </div>
</x-filament-panels::page>
