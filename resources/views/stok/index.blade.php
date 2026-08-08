<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }} - {{ $produk->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Konten halaman Stok Anda di sini -->
            
            {{-- Jika Anda ada menggunakan @if di dalam sini, pastikan ada @endif --}}
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif {{-- <-- Periksa apakah yang seperti ini sudah ditutup --}}
           <div class="mb-4">
                <x-button color="primary" x-data="" x-on:click="$dispatch('open-modal', 'modal-tambah-stok')">
                    <i class="fas fa-plus mr-2"></i> Tambah Stok
                </x-button>
            </div>
            <div class="table-shell">
            <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="table-th text-left align-middle pb-3 pt-3 pl-2">Jumlah Stok</th>
                    <th class="table-th text-left align-middle pb-3 pt-3 pl-2">Type Stok</th>
                    <th class="table-th text-left align-middle pb-3 pt-3 pl-2">Harga Modal</th>
                    <th class="table-th text-center align-middle pb-3 pt-3">Actions</th>
                </tr>
            </thead>
                <tbody>
                    @foreach($data as $stok)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $stok->jumlah }}</td>
                            <td class="py-2 px-4 border-b">{{ $stok->type }}</td>
                            <td class="py-2 px-4 border-b">{{ $stok->harga_modal }}</td>
                            <td class="py-2 px-4 border-b flex justify-center gap-2 items-center">
                                
                                <form action="{{ route('admin.stok.destroy', $stok->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <!--  MODAL TAMBAH STOK -->
    <x-modal name="modal-tambah-stok" focusable>
        <form action="{{ route('admin.stok.store') }}" method="POST" class="p-1 m-2">
            @csrf

            <div class="space-y-6 pb-4 mx-2">
              <h2 class="text-lg font-semibold text-gray-900 mb-4">
                Tambah Stok Baru
            </h2>
            <input type="hidden" name="produk_id" value="{{ $id }}">
            <div>
                <x-input-label for="type" :value="__('Type Stok')" />
                <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                    <option value="">Pilih Type Stok</option>
                    <option value="in">Stok Masuk</option>
                    <option value="out">Stok Keluar</option>
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="jumlah" :value="__('Jumlah Stok')" />
                <x-text-input id="jumlah" name="jumlah" type="number" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="harga_modal" :value="__('Harga Modal')" />
                <x-text-input id="harga_modal" name="harga_modal" type="number" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('harga_modal')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-2">
                {{-- Gunakan x-on:click="show = false" untuk menutup komponen x-modal ini --}}
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

</x-app-layout> {{-- <-- Pastikan tag penutup layout ini ada di paling bawah file --}}
