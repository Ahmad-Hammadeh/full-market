<?php

use Illuminate\Database\Seeder;
use App\Model\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // For Laptop Category
        for ($i=1; $i <= 30; $i++) {
            Product::create([
                'name' => 'Laptop ' . $i,
                'slug' => 'laptop_' . $i,
                'details' => 'Some details for ' . $i,
                'description' => 'All description for the product whos have number ' . $i,
                'price' => rand(1500, 6000),
                'image' => 'images/products/laptop_' . $i . '.jpg',
                'images' => json_encode( [ "images/products/laptop_" . rand(1, 30) . ".jpg", "images/products/laptop_" . rand(0, 30) . ".jpg", "images/products/laptop_" . rand(0, 30) . ".jpg" ] ),
                'featured' => array_rand([true, false]),
                'quantity' => rand(1, 10)
                ])->categories()->attach(1);
        }

        // Attach Addition Category To Some Product
        Product::find(1)->categories()->attach(2);

        // For Mobile Category
        for ($i=1; $i <= 10; $i++) {
            Product::create([
                'name' => 'Mobile ' . $i,
                'slug' => 'mobile_' . $i,
                'details' => 'Some details for ' . $i,
                'description' => 'All description for the product whos have number ' . $i,
                'price' => rand(100, 500),
                'image' => 'images/products/mobile_' . $i . '.jpg',
                'images' => json_encode( [ "images/products/mobile_" . rand(1, 10) . ".jpg", "images/products/mobile_" . rand(0, 10) . ".jpg", "images/products/mobile_" . rand(0, 10) . ".jpg" ] ),
                'featured' => array_rand([true, false]),
                'quantity' => rand(1, 10)
                ])->categories()->attach(2);
        }

        // For Furniture Category
        for ($i=1; $i <= 10; $i++) {
            Product::create([
                'name' => 'Furniture ' . $i,
                'slug' => 'furniture_' . $i,
                'details' => 'Some details for ' . $i,
                'description' => 'All description for the product whos have number ' . $i,
                'price' => rand(200, 5000),
                'image' => 'images/products/furniture_' . $i . '.jpg',
                'images' => json_encode( [ "images/products/furniture_" . rand(1, 10) . ".jpg", "images/products/furniture_" . rand(0, 10) . ".jpg", "images/products/furniture_" . rand(0, 10) . ".jpg" ] ),
                'featured' => array_rand([true, false]),
                'quantity' => rand(1, 10)
                ])->categories()->attach(3);
        }
    }
}
