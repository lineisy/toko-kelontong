<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-lg shadow p-8 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-red-100 flex items-center justify-center text-red-600 mb-4">
                    <i class="fas fa-user text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800">
                    Selamat datang, {{ Auth::user()->name }}!
                </h3>
                <p class="text-gray-500 mt-1">
                    Siap melayani transaksi hari ini.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <a href="{{ route('kasir.transaksi') }}" class="bg-red-600 hover:bg-red-700 transition text-white rounded-lg shadow p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                        <i class="fas fa-cash-register text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-lg">Mulai Transaksi</p>
                        <p class="text-sm text-white/80">Layani pembelian pelanggan</p>
                    </div>
                </a>

                <a href="{{ route('kasir.produk') }}" class="bg-white hover:bg-gray-50 transition border border-gray-200 rounded-lg shadow p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                        <i class="fas fa-box text-xl"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-lg text-gray-800">Lihat Produk</p>
                        <p class="text-sm text-gray-500">Cek daftar produk & stok</p>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>