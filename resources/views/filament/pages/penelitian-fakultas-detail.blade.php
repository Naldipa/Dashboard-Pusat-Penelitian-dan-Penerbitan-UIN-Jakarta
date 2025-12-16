<x-filament-panels::page>
    <div class="space-y-4">

        {{-- Header --}}
        <div>
            <p class="text-[11px] font-semibold tracking-[0.16em] text-indigo-500 uppercase">
                Pusat Penelitian &amp; Penerbitan · UIN Jakarta
            </p>
            <h2 class="text-base font-semibold text-slate-900">
                Kategori: Data Penelitian
                <span class="text-sm font-normal text-slate-600">
                    ({{ $totalDokumen }} Dokumen)
                </span>
            </h2>
            <p class="text-xs text-slate-500">
                Fakultas: <span class="font-semibold text-slate-800">{{ $fakultas }}</span>
            </p>
        </div>

        {{-- BLOK 1: Diterima / Disetujui / Dibayar --}}
        <div class="rounded-xl border border-emerald-200 bg-emerald-50/80 overflow-hidden">
            <div class="px-4 py-2.5 border-b border-emerald-200 bg-emerald-100/80">
                <h3 class="text-xs font-semibold text-emerald-800">
                    DITERIMA / DISETUJUI / DIBAYAR
                    <span class="font-normal">
                        ({{ $diterima->count() }} Dokumen)
                    </span>
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-[12px]">
                    <thead>
                        <tr class="bg-emerald-50 text-emerald-900">
                            <th class="px-4 py-2 text-left font-semibold">Judul Dokumen</th>
                            <th class="px-4 py-2 text-left font-semibold">Klaster</th>
                            <th class="px-4 py-2 text-left font-semibold">Penulis Utama</th>
                            <th class="px-4 py-2 text-left font-semibold">Prodi</th>
                            <th class="px-4 py-2 text-left font-semibold">Tahun</th>
                            <th class="px-4 py-2 text-left font-semibold">Status</th>
                            <th class="px-4 py-2 text-right font-semibold">Detail Siap</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($diterima as $item)
                            <tr class="bg-white border-t border-emerald-100">
                                <td class="px-4 py-2 align-top">
                                    <a href="#"
                                       class="text-indigo-600 hover:underline">
                                        {{ $item->judul }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 align-top">
                                    {{ $item->klaster ?? '-' }}
                                </td>
                                <td class="px-4 py-2 align-top font-semibold text-slate-800">
                                    {{ $item->penulis_utama ?? '-' }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    {{ $item->prodi ?? '-' }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    {{ $item->tahun ?? '-' }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700">
                                        {{ strtoupper($item->status ?? 'DITERIMA') }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 align-top text-right">
                                    <button type="button"
                                    wire:click="showDetail({{ $item->id }})"
                                    class="text-indigo-600 text-[11px] font-medium hover:underline">
                                    Lihat Data
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-[11px] text-slate-500">
                                    Belum ada dokumen pada kategori ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- BLOK 2: Ditolak / Diproses / Tertunda --}}
        <div class="rounded-xl border border-rose-200 bg-rose-50/80 overflow-hidden">
            <div class="px-4 py-2.5 border-b border-rose-200 bg-rose-100/80">
                <h3 class="text-xs font-semibold text-rose-800">
                    DITOLAK / DIPROSES / TERTUNDA
                    <span class="font-normal">
                        ({{ $ditolak->count() }} Dokumen)
                    </span>
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-[12px]">
                    <thead>
                        <tr class="bg-rose-50 text-rose-900">
                            <th class="px-4 py-2 text-left font-semibold">Judul Dokumen</th>
                            <th class="px-4 py-2 text-left font-semibold">Klaster</th>
                            <th class="px-4 py-2 text-left font-semibold">Penulis Utama</th>
                            <th class="px-4 py-2 text-left font-semibold">Prodi</th>
                            <th class="px-4 py-2 text-left font-semibold">Tahun</th>
                            <th class="px-4 py-2 text-left font-semibold">Status</th>
                            <th class="px-4 py-2 text-right font-semibold">Detail Siap</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ditolak as $item)
                            <tr class="bg-white border-t border-rose-100">
                                <td class="px-4 py-2 align-top">
                                    <a href="#"
                                       class="text-indigo-600 hover:underline">
                                        {{ $item->judul }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 align-top">
                                    {{ $item->klaster ?? '-' }}
                                </td>
                                <td class="px-4 py-2 align-top font-semibold text-slate-800">
                                    {{ $item->penulis_utama ?? '-' }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    {{ $item->prodi ?? '-' }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    {{ $item->tahun ?? '-' }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    <span
                                        class="inline-flex items-center rounded-full bg-rose-100 px-2.5 py-0.5 text-[11px] font-semibold text-rose-700">
                                        {{ strtoupper($item->status ?? 'DITOLAK') }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 align-top text-right">
                                    <a href="#"
                                       class="text-indigo-600 text-[11px] font-medium hover:underline">
                                        Lihat Data
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-[11px] text-slate-500">
                                    Belum ada dokumen pada kategori ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Detail Penulis --}}
<x-filament::modal
    id="detail-penulis-modal"
    icon="heroicon-o-user-circle"
    width="md"
    heading="Data Penulis (SIAP)"
    :visible="$showDetailModal"
    :close-button="true"
    :slide-over="false"
    x-on:close-modal.window="$wire.set('showDetailModal', false)"
>
    @if ($selectedPenelitian)
        <div class="space-y-2 text-[13px]">
            <div class="grid grid-cols-3 gap-x-3">
                <div class="text-slate-500">ID Penulis</div>
                <div class="col-span-2 font-semibold text-slate-800">
                    {{ $selectedPenelitian->id_penulis ?? 'ID-' . $selectedPenelitian->id }}
                </div>

                <div class="text-slate-500">Nama Lengkap</div>
                <div class="col-span-2 font-semibold text-slate-800">
                    {{ $selectedPenelitian->penulis_utama ?? '-' }}
                </div>

                <div class="text-slate-500">NIP/NIDN/NRP</div>
                <div class="col-span-2 font-semibold text-slate-800">
                    {{ $selectedPenelitian->nip ?? 'NIP-' . $selectedPenelitian->id }}
                </div>

                <div class="text-slate-500">Prodi</div>
                <div class="col-span-2 font-semibold text-slate-800">
                    {{ $selectedPenelitian->prodi ?? 'Non-Akademik' }}
                </div>

                <div class="text-slate-500">Fakultas</div>
                <div class="col-span-2 font-semibold text-slate-800">
                    {{ $selectedPenelitian->fakultas ?? 'Unit Lain' }}
                </div>
            </div>

            <p class="mt-3 text-[11px] text-red-500">
                *Data ini disinkronisasi dari Akun SIAP Penulis.
            </p>
        </div>
    @endif

    <x-slot name="footer">
        <x-filament::button
            color="gray"
            x-on:click="$wire.set('showDetailModal', false)"
        >
            Tutup
        </x-filament::button>
    </x-slot>
</x-filament::modal>


        {{-- Tombol kembali --}}
        <div class="flex justify-end">
            <a href="{{ \App\Filament\Pages\PenelitianByFakultas::getUrl() }}"
               class="inline-flex items-center rounded-md bg-slate-800 px-4 py-2 text-xs font-medium text-white hover:bg-slate-900">
                Kembali ke Rekap Fakultas
            </a>
        </div>
    </div>
</x-filament-panels::page>
