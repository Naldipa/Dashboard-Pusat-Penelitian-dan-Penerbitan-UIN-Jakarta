<x-filament-panels::page>
    <div class="flex justify-center">
        {{-- Kartu utama di tengah, seperti dialog laporan --}}
        <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg border border-slate-200/80 p-6 space-y-5">
            {{-- Form upload CSV (dari Excel) --}}
<form action="{{ route('penelitian.import') }}" method="POST" enctype="multipart/form-data" class="mt-3">
    @csrf

    <div class="flex flex-wrap items-center gap-3">
        <div>
            <input type="file"
                   name="file_excel"
                   accept=".csv"
                   class="block w-56 text-xs border border-gray-300 rounded-md px-2 py-1
                          focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
            <p class="mt-1 text-[11px] text-gray-500">
                Gunakan file CSV (bisa diekspor dari Excel).
            </p>
        </div>

        <button type="submit"
                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-700">
            Upload Data Penelitian
        </button>

        @if (session('success'))
            <span class="text-[11px] text-emerald-600">
                {{ session('success') }}
            </span>
        @endif

        @error('file_excel')
            <span class="text-[11px] text-red-600">
                {{ $message }}
            </span>
        @enderror
    </div>
</form>

            {{-- Tabel rekap fakultas --}}
            <div class="overflow-hidden rounded-xl border border-slate-200/80">
                <table class="min-w-full text-[13px] border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th
                                class="px-4 py-2.5 text-left text-[11px] font-semibold tracking-[0.12em] text-slate-500 uppercase">
                                Fakultas
                            </th>
                            <th
                                class="px-4 py-2.5 text-right text-[11px] font-semibold tracking-[0.12em] text-slate-500 uppercase">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->fakultas as $index => $item)
                            <tr
                                class="@if($index % 2 === 0) bg-white @else bg-slate-50/70 @endif hover:bg-indigo-50/60 transition-colors">
                                <td class="px-4 py-2.5 text-slate-800">
                                    <a href="{{ route('filament.admin.pages.penelitian-fakultas', ['fakultas' => $item['nama']]) }}"
                                    class="text-slate-800 hover:text-indigo-600 hover:underline">
                                        {{ $item['nama'] }}
                                    </a>
                                </td>
                                <td class="px-4 py-2.5 text-right">
                                    <span class="font-semibold text-slate-900">
                                        {{ $item['jumlah'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Baris total keseluruhan --}}
                        <tr class="bg-indigo-50 border-t border-indigo-100">
                            <td
                                class="px-4 py-2.5 text-[11px] font-semibold tracking-[0.12em] text-slate-600 uppercase">
                                Total Keseluruhan (5 Tahun)
                            </td>
                            <td class="px-4 py-2.5 text-right">
                                <span class="text-sm font-bold text-indigo-700">
                                    {{ $this->totalKeseluruhan }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Tombol Tutup --}}
            <div class="flex justify-end pt-2">
                <a href="{{ \App\Filament\Pages\DashboardRiset::getUrl() }}"
                   class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-1">
                    Tutup
                </a>
            </div>

        </div>
    </div>
</x-filament-panels::page>
