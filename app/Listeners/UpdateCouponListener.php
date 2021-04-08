<?php

namespace App\Listeners;

use App\Jobs\UpdateCouponJob;
use App\Model\Coupon;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCouponListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $coupon_name = session()->get('coupon')['code'];

        $coupon = Coupon::where( 'code', $coupon_name )->first();

        if( $coupon ) {

            UpdateCouponJob::dispatchNow($coupon);

        }
    }
}
