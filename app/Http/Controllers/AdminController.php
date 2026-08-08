<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $title = 'Dashboard Admin';

        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();

        $transaksiHariIni = Penjualan::whereDate('tanggal', today())->count();
        $pendapatanHariIni = Penjualan::whereDate('tanggal', today())->sum('total');

        $transaksiTerbaru = Penjualan::with('user')
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'title',
            'totalProduk',
            'totalKategori',
            'transaksiHariIni',
            'pendapatanHariIni',
            'transaksiTerbaru'
        ));
    }

    public function transaksi(): View
    {
        $title = 'Transaksi Admin';
        $produk = Produk::with('kategori')->get();
        $produkList = $produk->map(fn ($item) => [
            'id' => $item->id,
            'name' => $item->name,
            'harga' => (float) $item->harga,
        ])->values();

        return view('transaksi.index', compact('title', 'produk', 'produkList'));
    }

    public function laporanTransaksi(): View
    {
        $title = 'Laporan Transaksi';
        $penjualans = Penjualan::with(['user', 'detailPenjualan.produk'])
            ->latest('tanggal')
            ->get();

        return view('admin.laporan-transaksi', compact('title', 'penjualans'));
    }

    public function storeTransaction(Request $request): RedirectResponse
    {
        $produkIdsInput = $request->input('produk_id');
        $jumlahInput = $request->input('jumlah');

        if (is_array($produkIdsInput)) {
            $request->validate([
                'produk_id' => 'required|array|min:1',
                'produk_id.*' => 'exists:produks,id',
                'jumlah' => 'required|array|min:1',
                'jumlah.*' => 'required|integer|min:1',
                'bayar' => 'required|numeric|min:0',
            ]);
            $produkIds = $produkIdsInput;
            $jumlahs = $jumlahInput;
        } else {
            $request->validate([
                'produk_id' => 'required|exists:produks,id',
                'jumlah' => 'required|integer|min:1',
                'bayar' => 'required|numeric|min:0',
            ]);
            $produkIds = [$produkIdsInput];
            $jumlahs = [$jumlahInput];
        }

        $items = [];
        $total = 0;

        foreach ($produkIds as $index => $produkId) {
            $produk = Produk::findOrFail($produkId);
            $jumlah = (int) ($jumlahs[$index] ?? 0);

            if ($jumlah < 1) {
                continue;
            }

            $subtotal = $produk->harga * $jumlah;
            $items[] = [
                'produk_id' => $produkId,
                'jumlah' => $jumlah,
                'harga' => $produk->harga,
            ];
            $total += $subtotal;
        }

        if (empty($items)) {
            return back()->withErrors(['produk_id' => 'Pilih setidaknya satu produk.'])->withInput();
        }

        $bayar = (float) $request->input('bayar');

        if ($bayar < $total) {
            return back()->withErrors(['bayar' => 'Nominal pembayaran kurang dari total transaksi.'])->withInput();
        }

        $kembalian = $bayar - $total;

        DB::transaction(function () use ($items, $total, $bayar, $kembalian) {
            $penjualan = Penjualan::create([
                'user_id' => Auth::id(),
                'total' => number_format($total, 2, '.', ''),
                'bayar' => number_format($bayar, 2, '.', ''),
                'kembalian' => number_format($kembalian, 2, '.', ''),
                'tanggal' => now(),
            ]);

            foreach ($items as $item) {
                $penjualan->detailPenjualan()->create([
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah'],
                    'harga' => number_format($item['harga'], 2, '.', ''),
                ]);
            }
        });

        $kembalianFormatted = 'Rp ' . number_format($kembalian, 0, ',', '.');

        return redirect()->route('admin.transaksi')
            ->with('success', "Transaksi berhasil disimpan. Kembalian: {$kembalianFormatted}");
    }
}