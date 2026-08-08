<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <x-button color="primary" x-data="" x-on:click="$dispatch('open-modal', 'modal-tambah-kategori')">
                    <i class="fas fa-plus mr-2"></i> Tambah Kategori
                </x-button>
            </div>

            <div class="table-shell">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="table-th text-left align-middle pb-3 pt-3 pl-2">Nama</th>
                        <th class="table-th text-center align-middle pb-3 pt-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $kategori)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $kategori->name }}</td>
                            <td class="py-2 px-4 border-b flex justify-center gap-2 items-center">
                                <x-button color="warning" x-data="" x-on:click="$dispatch('open-modal', 'modal-edit-kategori-{{ $kategori->id }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </x-button>

                                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Kategori -->
                        <x-modal name="modal-edit-kategori-{{ $kategori->id }}" focusable>
                            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" class="p-6 m-0">
                                @csrf
                                @method('PUT')
                                <div class="space-y-6 pb-4 mx-2">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                                        Edit Nama Kategori
                                    </h2>

                                    <div>
                                        <x-input-label for="name" :value="__('Nama Kategori')" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ $kategori->name }}" required autofocus />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div class="mt-6 flex justify-end gap-2">
                                        <x-button color="secondary" type="button" x-on:click="show = false">
                                            Batal
                                        </x-button>
                                        <x-button color="warning" type="submit">
                                            Simpan Perubahan
                                        </x-button>
                                    </div>
                                </div>
                            </form>
                        </x-modal>
                    @empty
                        <tr>
                            <td colspan="2" class="py-4 px-4 text-center text-gray-400">
                                Belum ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>

        </div>
    </div>

    <!-- MODAL TAMBAH KATEGORI -->
    <x-modal name="modal-tambah-kategori" focusable>
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="p-1 m-2">
            @csrf
            <div class="space-y-6 pb-4 mx-2">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    Tambah Kategori Baru
                </h2>

                <div>
                    <x-input-label for="name" :value="__('Nama Kategori')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <x-button color="secondary" type="button" x-on:click="show = false">
                        Batal
                    </x-button>
                    <x-button color="success" type="submit">
                        Simpan Data
                    </x-button>
                </div>
            </div>
        </form>
    </x-modal>
</x-app-layout>