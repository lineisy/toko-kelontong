<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiTest extends TestCase
{
    use RefreshDatabase;

    public function test_kasir_can_create_transaction_with_detail(): void
    {
        $user = User::factory()->create(['role' => 'kasir']);
        $kategori = Kategori::create(['name' => 'Minuman']);
        $produk = Produk::create([
            'kategori_id' => $kategori->id,
            'code' => 'MIN-001',
            'name' => 'Teh Botol',
            'harga' => 1000,
        ]);

        $response = $this->actingAs($user)->post(route('kasir.transaksi.store'), [
            'produk_id' => $produk->id,
            'jumlah' => 2,
            'bayar' => 5000,
        ]);

        $response->assertRedirect(route('kasir.transaksi'));
        $this->assertDatabaseHas('penjualans', [
            'user_id' => $user->id,
            'total' => '2000.00',
            'bayar' => '5000.00',
            'kembalian' => '3000.00',
        ]);
        $this->assertDatabaseHas('detail_penjualans', [
            'produk_id' => $produk->id,
            'jumlah' => 2,
            'harga' => '1000.00',
        ]);
    }
}
