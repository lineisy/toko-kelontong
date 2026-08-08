<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $title = 'Daftar Stok';
        $data = Stok::with('produk')->where('produk_id', $id)->get();
        $produk = Produk::findOrFail($id);
        return view('stok.index', compact('title', 'data', 'id', 'produk'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'type' => 'required|in:in,out',
            'jumlah' => 'required|integer|min:1',
            'harga_modal' => 'required|numeric|min:0',
        ]);

        Stok::create($request->all());

        return redirect()->route('admin.produk.stock', $request->produk_id)->with('success', 'Stok berhasil ditambahkan.');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stok = Stok::findOrFail($id);
        $produkId = $stok->produk_id; // Simpan produk_id sebelum menghapus stok
        $stok->delete();

        return redirect()->route('admin.produk.stock', $produkId)->with('success', 'Stok berhasil dihapus.');
    }
}
