<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Playstation', 'Drums', 'Football', 'Smart TV', 'Sunglasses', 'Shoes'];
        for ($i = 0; $i < 6; $i++) { 
            DB::table('products')->insert([
                'name' => $names[$i],
                'price' => rand(10,500),
                'description' => $names[$i] . ' description',
                'image_url' => $names[$i] . '.image.com',
                'quantity' => rand(1, 20)
            ]);
        }
    }
}
