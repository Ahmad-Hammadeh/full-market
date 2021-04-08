<?php

use App\Model\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        Category::insert([
            [
                'name' => 'Laptop',
                'slug' => 'laptop',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'Mobile',
                'slug' => 'mobile',
                'created_at' => $now,
                'updated_at' => $now
            ],[
                'name' => 'Furniture',
                'slug' => 'furniture',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
