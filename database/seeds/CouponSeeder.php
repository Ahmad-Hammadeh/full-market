<?php

use App\Model\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'code' => '123ABC',
            'type' => 'fixed_value',
            'fixed_value' => 70
        ]);

        Coupon::create([
            'code' => '321ABC',
            'type' => 'percent_value',
            'percent_value' => 30
        ]);
    }
}
