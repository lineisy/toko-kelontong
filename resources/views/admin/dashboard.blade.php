<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- ================= KARTU STATISTIK ================= -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                        <i class="fas fa-box text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalProduk }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                        <i class="fas fa-tags text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Kategori</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalKategori }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                        <i class="fas fa-receipt text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $transaksiHariIni }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                        <i class="fas fa-money-bill-wave text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pendapatan Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
                    </div>
                </div>

            </div>

            <!-- ================= TRANSAKSI TERBARU ================= -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h3>
                    <a href="{{ route('admin.laporan.transaksi') }}" class="text-sm text-red-600 hover:underline">
                        Lihat semua &rarr;
                    </a>
                </div>

                <div class="table-shell overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="table-th text-left align-middle pb-3 pt-3 pl-2">Tanggal</th>
                                <th class="table-th text-left align-middle pb-3 pt-3">Kasir</th>
                                <th class="table-th text-center align-middle pb-3 pt-3">Total</th>
                                <th class="table-th text-center align-middle pb-3 pt-3">Bayar</th>
                                <th class="table-th text-center align-middle pb-3 pt-3">Kembalian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $trx)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d-m-Y H:i') }}</td>
                                    <td class="py-2 px-4 border-b">{{ $trx->user->name ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b text-center">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 border-b text-center">Rp {{ number_format($trx->bayar, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 border-b text-center">Rp {{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-4 text-center text-gray-400">
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>