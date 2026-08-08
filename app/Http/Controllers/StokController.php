<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Menampilkan stok berdasarkan produk.
     */
    public function index($id)
    {
        $title = 'Daftar Stok';

        $data = Stok::with('produk')
            ->where('produk_id', $id)
            ->get();

        $produk = Produk::findOrFail($id);

        return view('stok.index', compact(
            'title',
            'data',
            'id',
            'produk'
        ));
    }

    /**
     * Menambahkan stok.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'type' => 'required|in:in,out',
            'jumlah' => 'required|integer|min:1',
            'harga_modal' => 'required|numeric|min:0',
        ]);

        Stok::create($request->all());

        return redirect()
            ->route('admin.produk.stock', $request->produk_id)
            ->with('success', 'Stok berhasil ditambahkan.');
    }

    /**
     * Menghapus stok.
     */
    public function destroy(string $id)
    {
        $stok = Stok::findOrFail($id);

        $produkId = $stok->produk_id;

        $stok->delete();

        return redirect()
            ->route('admin.produk.stock', $produkId)
            ->with('success', 'Stok berhasil dihapus.');
    }
}