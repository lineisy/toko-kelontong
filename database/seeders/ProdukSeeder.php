<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productGroups = [
            'Makanan Anjing' => [
                ['name' => 'Kibble / makanan kering anjing', 'harga' => 120000],
                ['name' => 'Wet food / makanan basah anjing', 'harga' => 90000],
                ['name' => 'Snack / camilan anjing', 'harga' => 45000],
            ],
            'Makanan Kucing' => [
                ['name' => 'Makanan kering kucing', 'harga' => 115000],
                ['name' => 'Makanan basah kucing', 'harga' => 85000],
                ['name' => 'Snack / camilan kucing', 'harga' => 40000],
            ],
            'Makanan Burung' => [
                ['name' => 'Makanan burung', 'harga' => 60000],
                ['name' => 'Biji-bijian burung', 'harga' => 55000],
                ['name' => 'Tempat pakan burung', 'harga' => 70000],
            ],
            'Mainan' => [
                ['name' => 'Mainan berbunyi kucing', 'harga' => 65000],
                ['name' => 'Interactive toy kucing', 'harga' => 75000],
                ['name' => 'Chew toy anjing', 'harga' => 80000],
                ['name' => 'Interactive toy anjing', 'harga' => 85000],
                ['name' => 'Swimming toy ikan', 'harga' => 50000],
            ],
            'Kandang & Habitat' => [
                ['name' => 'Kandang burung', 'harga' => 180000],
                ['name' => 'Kandang hamster', 'harga' => 140000],
                ['name' => 'Kandang kelinci', 'harga' => 220000],
                ['name' => 'Kandang hewan kecil', 'harga' => 160000],
                ['name' => 'Kandang reptil', 'harga' => 200000],
                ['name' => 'Kandang iguana', 'harga' => 240000],
                ['name' => 'Kandang kura-kura', 'harga' => 210000],
            ],
            'Tempat Tidur' => [
                ['name' => 'Pet bed', 'harga' => 130000],
                ['name' => 'Hammock kucing', 'harga' => 110000],
                ['name' => 'Heated bed', 'harga' => 170000],
                ['name' => 'Bamboo bedding', 'harga' => 90000],
            ],
            'Aksesoris' => [
                ['name' => 'Collar anjing', 'harga' => 60000],
                ['name' => 'Leash anjing', 'harga' => 80000],
                ['name' => 'Harness anjing', 'harga' => 120000],
                ['name' => 'Chain anjing besar', 'harga' => 150000],
                ['name' => 'Flea collar', 'harga' => 70000],
                ['name' => 'Pakaian anjing', 'harga' => 95000],
                ['name' => 'Pakaian kucing', 'harga' => 90000],
                ['name' => 'Booties anjing', 'harga' => 65000],
                ['name' => 'Carrier hewan', 'harga' => 180000],
            ],
            'Grooming' => [
                ['name' => 'Shampoo', 'harga' => 50000],
                ['name' => 'Conditioner', 'harga' => 48000],
                ['name' => 'Brush/sisir', 'harga' => 40000],
                ['name' => 'Sikat', 'harga' => 35000],
                ['name' => 'Nail clippers', 'harga' => 30000],
            ],
            'Kesehatan' => [
                ['name' => 'Obat cacing', 'harga' => 45000],
                ['name' => 'Suplemen', 'harga' => 95000],
                ['name' => 'Obat kutu', 'harga' => 60000],
                ['name' => 'Obat anti-kutu/tick treatment', 'harga' => 110000],
            ],
            'Kucing' => [
                ['name' => 'Litter box', 'harga' => 100000],
                ['name' => 'Cat litter', 'harga' => 75000],
                ['name' => 'Litter scoop', 'harga' => 25000],
            ],
            'Aquarium & Ikan' => [
                ['name' => 'Aquarium', 'harga' => 300000],
                ['name' => 'Aksesori aquarium', 'harga' => 90000],
                ['name' => 'Filter air', 'harga' => 180000],
                ['name' => 'Pompa aquarium', 'harga' => 160000],
                ['name' => 'Makanan ikan', 'harga' => 50000],
                ['name' => 'Automatic fish feeder', 'harga' => 220000],
            ],
            'Reptil & Hewan Eksotis' => [
                ['name' => 'Reptil dan amfibi', 'harga' => 140000],
                ['name' => 'Kandang reptil', 'harga' => 220000],
                ['name' => 'Makanan reptil', 'harga' => 65000],
                ['name' => 'Makanan iguana', 'harga' => 70000],
                ['name' => 'Makanan kura-kura', 'harga' => 68000],
                ['name' => 'Kandang iguana/kura-kura', 'harga' => 260000],
                ['name' => 'Lampu UVB', 'harga' => 120000],
            ],
        ];

        foreach ($productGroups as $categoryName => $products) {
            $category = Kategori::where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            foreach ($products as $index => $product) {
                Produk::firstOrCreate(
                    ['code' => 'PRD-' . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(str_replace(' ', '', $categoryName), 0, 3))],
                    [
                        'name' => $product['name'],
                        'harga' => $product['harga'],
                        'kategori_id' => $category->id,
                    ]
                );
            }
        }
    }
}
