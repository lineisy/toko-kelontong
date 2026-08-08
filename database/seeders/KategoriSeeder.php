<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Makanan Anjing',
            'Makanan Kucing',
            'Makanan Burung',
            'Mainan',
            'Kandang & Habitat',
            'Tempat Tidur',
            'Aksesoris',
            'Grooming',
            'Kesehatan',
            'Kucing',
            'Aquarium & Ikan',
            'Reptil & Hewan Eksotis',
        ];

        foreach ($categories as $category) {
            Kategori::firstOrCreate(['name' => $category]);
        }
    }
}
