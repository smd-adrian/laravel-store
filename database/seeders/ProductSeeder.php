<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'title' => 'Gorra deportiva',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec accumsan dui.',
            'photo' => 'gorra-deportiva.jpg',
            'price' => '20500'
        ]);
    }
}
