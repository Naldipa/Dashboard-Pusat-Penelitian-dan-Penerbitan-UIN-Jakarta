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
                <select
                    class="border-gray-300 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025" selected>2025</option>
                </select>
            </div>
        </div>

        {{-- Statistik ringkas (kartu-kartu Filament) --}}
        @livewire(\App\Filament\Widgets\DashboardStats::class)

        {{-- Grid: Grafik + Tabel Fakultas --}}
        <div class="grid gap-6 md:grid-cols-3">
            {{-- Grafik Batang: ambil 2 kolom di layar besar --}}
            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow">
                @livewire(name: \App\Filament\Widgets\DashboardChart::class)
            </div>

            {{-- Tabel Fakultas: 1 kolom di kanan --}}
            <div class="bg-white p-6 rounded-xl shadow">
                @livewire(\App\Http\Livewire\FakultasTable::class)
            </div>
        </div>
    </div>
</x-filament-panels::page>
