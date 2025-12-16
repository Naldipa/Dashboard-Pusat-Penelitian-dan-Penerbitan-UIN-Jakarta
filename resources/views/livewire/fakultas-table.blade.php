<div class="space-y-4">
    {{-- Judul + badge total, seperti di screenshot --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-semibold text-gray-800">
                Daftar Dokumen &amp; Data Penulis Berdasarkan Fakultas
            </h3>
            <p class="mt-1 text-xs text-gray-500">
                Rekap total dokumen penelitian per fakultas selama 5 tahun terakhir.
            </p>
        </div>

        <span
            class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
            {{ $this->totalKeseluruhan }} Total
        </span>
    </div>

    <div class="border border-gray-200 rounded-xl overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th
                        class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide">
                        Fakultas
                    </th>
                    <th
                        class="px-4 py-2 text-right text-xs font-semibold uppercase tracking-wide">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($this->fakultas as $index => $item)
                    <tr @class([
                        'bg-white' => $index % 2 === 0,
                        'bg-gray-50/60' => $index % 2 === 1,
                    ])>
                        <td class="px-4 py-2 whitespace-nowrap text-gray-800">
                            {{ $item['nama'] }}
                        </td>
                        <td class="px-4 py-2 text-right font-semibold text-gray-900">
                            {{ $item['jumlah'] }}
                        </td>
                    </tr>
                @endforeach

                {{-- Baris total keseluruhan (5 tahun) --}}
                <tr class="bg-indigo-50 border-t border-indigo-100">
                    <td
                        class="px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-700">
                        TOTAL KESELURUHAN (5 Tahun)
                    </td>
                    <td
                        class="px-4 py-2 text-right text-sm font-bold text-indigo-700">
                        {{ $this->totalKeseluruhan }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
