<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header & Back Button --}}
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white hidden">
                {{ $fakultas }}
            </h2>
            <x-filament::button
                color="gray"
                tag="a"
                {{-- Go back to the Index page of the Resource --}}
                href="{{ \App\Filament\Resources\Penelitians\PenelitianResource::getUrl('index') }}"
                icon="heroicon-m-chevron-left"
            >
                Kembali ke Rekapitulasi
            </x-filament::button>
        </div>

        {{-- FILAMENT TABLE RENDER --}}
        {{ $this->table }}

    </div>
</x-filament-panels::page>
