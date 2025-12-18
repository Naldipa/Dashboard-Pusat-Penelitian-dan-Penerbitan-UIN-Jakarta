<x-filament-panels::page>
    <div class="space-y-8">

        {{-- Header halaman + dropdown periode --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">
                    Ringkasan Kinerja Riset &amp; Publikasi
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Pusat Penelitian &amp; Penerbitan UIN Jakarta · Periode 2021–2025
                </p>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Periode:</label>
                <select class="border-gray-300 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025" selected>2025</option>
                </select>
            </div>
        </div>

        {{-- Kartu ringkas: Data Penelitian, Insentif, Tagihan Publikasi, Bantuan Buku Referensi --}}
        @livewire(\App\Filament\Widgets\DashboardStats::class)

        {{-- Chart/Stats Total Kumulatif 5 Tahun --}}
        <div class="p-0 bg-transparent shadow-none">
            @livewire(\App\Filament\Widgets\DashboardChart::class)
        </div>

        <div class="p-0 bg-transparent shadow-none">
            @livewire(\App\Filament\Widgets\DashboardData::class)
        </div>

    </div>
</x-filament-panels::page>
