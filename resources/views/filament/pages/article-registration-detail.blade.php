<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                {{ $fakultas }}
            </h2>
            <x-filament::button
                color="gray"
                tag="a"
                href="{{ \App\Filament\Pages\ArticleRegistrationData::getUrl() }}"
                icon="heroicon-m-chevron-left"
            >
                Kembali
            </x-filament::button>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>
