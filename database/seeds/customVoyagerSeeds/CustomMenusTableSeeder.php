<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;

class CustomMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        Menu::firstOrCreate([
            'name' => 'nav',
        ]);

        Menu::firstOrCreate([
            'name' => 'footer',
        ]);
    }
}
