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

            @if(Auth::user()->role === 'admin')
                <div class="mb-4">
                    <x-button color="primary" x-data="" x-on:click="$dispatch('open-modal', 'modal-tambah-produk')">
                        <i class="fas fa-plus mr-2"></i> Tambah Produk
                    </x-button>
                </div>
            @endif

            <div class="table-shell">
            <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="table-th text-left align-middle pb-3 pt-3 pl-2">Nama Produk</th>
                    <th class="table-th text-center align-middle pb-3 pt-3 pl-2">Kode Produk</th>
                    <th class="table-th text-center align-middle pb-3 pt-3">Kategori</th>
                    <th class="table-th text-center align-middle pb-3 pt-3">Harga</th>
                    <th class="table-th text-center align-middle pb-3 pt-3">Detail Stok</th>
                    @if(Auth::user()->role === 'admin')
                        <th class="table-th text-center align-middle pb-3 pt-3">Actions</th>
                    @endif
                </tr>
            </thead>
                <tbody>
                    @foreach($data as $produk)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $produk->name }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $produk->code }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $produk->kategori->name ?? 'Tidak ada kategori' }}</td>
                            <td class="py-2 px-4 border-b text-center">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <x-button color="info">
                                    <a href="{{ route('admin.produk.stock', $produk->id) }}">
                                        <i class="fas fa-eye"></i> Lihat Stok
                                    </a>
                                </x-button>
                            </td>

                            @if(Auth::user()->role === 'admin')
                                <td class="py-2 px-4 border-b flex justify-center gap-2 items-center">
                                    <x-button color="warning" x-data="" x-on:click="$dispatch('open-modal', 'modal-edit-produk-{{ $produk->id }}')">
                                        <i class="fas fa-edit"></i> Edit
                                    </x-button>

                                    <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                    </form>
                                </td>
                            @endif
                        </tr>

                        @if(Auth::user()->role === 'admin')
                            <!-- Modal Edit Produk -->
                            <x-modal name="modal-edit-produk-{{ $produk->id }}" focusable>
                                <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" class="pt-4 m-0">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-6 pb-4 mx-2">
                                        <h2 class="text-lg font-semibold text-gray-900 mb-4">
                                            Edit Nama Produk
                                        </h2>

                                        <div>
                                            <x-input-label for="name" :value="__('Nama Produk')" />
                                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ $produk->name }}" required autofocus />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="code" :value="__('Kode Produk')" />
                                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" value="{{ $produk->code }}" required />
                                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="kategori_id" :value="__('Kategori')" />
                                            <select id="kategori_id" name="kategori_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                                <option value="">Pilih Kategori</option>
                                                @foreach($kategori as $k)
                                                    <option value="{{ $k->id }}" {{ $produk->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="harga" :value="__('Harga')" />
                                            <x-text-input id="harga" name="harga" type="number" class="mt-1 block w-full" value="{{ $produk->harga }}" required />
                                            <x-input-error :messages="$errors->get('harga')" class="mt-2" />
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
                        @endif
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

    @if(Auth::user()->role === 'admin')
        <!-- MODAL TAMBAH PRODUK -->
        <x-modal name="modal-tambah-produk" focusable>
            <form action="{{ route('admin.produk.store') }}" method="POST" class="p-1 m-2">
                @csrf

                <div class="space-y-6 pb-4 mx-2">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        Tambah Produk Baru
                    </h2>

                    <div>
                        <x-input-label for="name" :value="__('Nama Produk')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="code" :value="__('Kode Produk')" />
                        <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="kategori_id" :value="__('Kategori')" />
                        <select id="kategori_id" name="kategori_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="harga" :value="__('Harga')" />
                        <x-text-input id="harga" name="harga" type="number" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
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
    @endif

</x-app-layout>