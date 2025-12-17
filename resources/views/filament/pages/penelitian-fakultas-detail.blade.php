<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Your Header / Title --}}
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $fakultas }}
            </h2>
            <x-filament::button color="gray" tag="a" href="{{ \App\Filament\Pages\DashboardRiset::getUrl() }}">
                Kembali
            </x-filament::button>
        </div>

        {{-- TABLE EXAMPLE (Just showing where to put the button) --}}
        <x-filament::section>
            <x-slot name="heading">Daftar Penelitian</x-slot>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-200 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Penulis</th>
                            <th class="px-4 py-3">Tahun</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Combine both lists for display, or loop separately as you were doing --}}
                        @foreach ($diterima->merge($ditolak) as $item)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-4 py-3 font-medium text-gray-200 dark:text-white">
                                    {{ $item->judul }}
                                </td>
                                <td class="px-4 py-3">{{ $item->penulis_utama }}</td>
                                <td class="px-4 py-3">{{ $item->tahun }}</td>
                                <td class="px-4 py-3">
                                    <x-filament::badge :color="$item->status === 'Diterima' ? 'success' : 'warning'">
                                        {{ $item->status }}
                                    </x-filament::badge>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{-- THE EDIT BUTTON --}}
                                    <button wire:click="edit({{ $item->id }})"
                                            class="text-primary-600 hover:text-primary-900 font-medium text-xs underline">
                                        Edit Data
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::section>

    {{-- Example button in your table: <button wire:click="edit({{ $item->id }})">Edit</button> --}}

    <x-filament::modal
        wire:model="isEditModalOpen"
        width="3xl"
    >
        <x-slot name="heading">
            Edit Data Penelitian
        </x-slot>

        <form wire:submit.prevent="save">
            {{ $this->form }}

            <div class="mt-6 flex justify-end gap-3">
                <x-filament::button color="gray" wire:click="$set('isEditModalOpen', false)">
                    Batal
                </x-filament::button>

                <x-filament::button type="submit">
                    Simpan Perubahan
                </x-filament::button>
            </div>
        </form>
    </x-filament::modal>

    {{-- Essential for Filament Modals to work --}}
    <x-filament-actions::modals />

    </div>
</x-filament-panels::page>
