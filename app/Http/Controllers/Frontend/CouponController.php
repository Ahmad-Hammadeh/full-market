<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateCouponJob;
use App\Model\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        $coupon = Coupon::where( 'code', $request->coupon_code )->first();

        if( ! $coupon ) {
            return redirect()->back()->withErrors( __('frontend.coupon_not_found'));
        }else {

            if( $coupon->used ) {
                return redirect()->back()->withErrors( __('frontend.coupon_used'));
            }else {

                UpdateCouponJob::dispatchNow($coupon);

                return redirect()->back()->with('success', __('frontend.coupon_applied'));

            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', __('frontend.coupon_removed'));
    }
}
