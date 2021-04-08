<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;

class CustomPermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {

        Permission::generateFor('products');

        Permission::generateFor('categories');

        Permission::generateFor('coupons');

        Permission::generateFor('orders');
    }
}
