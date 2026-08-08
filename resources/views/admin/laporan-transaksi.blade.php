<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Transaksi</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kasir</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Bayar</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kembalian</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($penjualans as $penjualan)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $penjualan->tanggal ? \Carbon\Carbon::parse($penjualan->tanggal)->format('d-m-Y H:i') : '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $penjualan->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <ul class="space-y-1">
                                            @foreach($penjualan->detailPenjualan as $detail)
                                                <li>
                                                    {{ $detail->produk->name ?? '-' }} - {{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">Belum ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
