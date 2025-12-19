<x-filament-panels::page>
    <div class="space-y-8">

        {{-- Header + Dropdown --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">
                    Ringkasan Kinerja Riset & Publikasi
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pusat Penelitian & Penerbitan UIN Jakarta
                </p>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-200">Periode:</label>

                {{-- 1. Bind to the Livewire Property --}}
                <select
                    wire:model.live="selectedYear"
                    class="block rounded-lg border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500"
                >
                    {{-- 1. The "All" Option --}}
                    <option value="all">Semua Periode</option>

                    {{-- 2. The Dynamic Years --}}
                    @foreach($this->years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{--
           3. Pass the selectedYear to your widgets.
           Using 'key' forces the widget to refresh when the year changes.
        --}}

        {{-- Stats Widget (Cards) --}}
        @livewire(\App\Filament\Widgets\DashboardStats::class, [
            'filterYear' => $selectedYear
        ], key('stats-' . $selectedYear))

        {{-- Chart Widget --}}
        <div class="rounded-xl border border-gray-200 bg-gray-900 p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            @livewire(\App\Filament\Widgets\DashboardData::class, [
                'filterYear' => $selectedYear
            ], key('chart-' . $selectedYear))
        </div>

    </div>
</x-filament-panels::page>
