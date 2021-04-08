<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    protected $fillable = ['code', 'type', 'fixed_value', 'percent_value', 'used'];

    // Check If  The Code Of Coupon Exists In Database
    public static function find_code($code)
    {
        return self::where( 'code', $code )->first();
    }

    // Get Discount Value
    public function get_discount($total_price)
    {
        if( $this->type === 'fixed_value' ) return $this->fixed_value;

        elseif( $this->type === 'percent_value' ) {

            $discount =  ( $this->percent_value * $total_price ) / 100;
            return app_number_format($discount);

        }else return 0;
    }

}
