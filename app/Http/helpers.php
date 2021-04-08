<?php

/**
 * Add Active Class To The Element
 * $request_name = The Request Name To Check Against
 * $value = The Value Of The Element To Check With
 * $class_name = The Class Name To Add To The Element In Case True
 */

if( ! function_exists('isActive') )
{

    function isActive($request_name, $value, $class_name='active')
    {
        return request($request_name) === $value ? 'active': '';
    }

}

if( ! function_exists('get_image') )
{

    function get_image($path)
    {
        return $path && file_exists('storage/' . $path) ? asset('storage/' . $path): asset('storage/general/defaul_product.png');
    }

}

if( ! function_exists('with_discount') )
{


    /**
     * Get The Shopping Cart values With Applied The Discount
     * Note:: We Get This values Manully, And We Not Used Cart Package Method "setDiscount"
     * Because Of This Method Use Just Percent Descount( Not The Fixed One )
     */

    function with_discount()
    {
        $discount_code = session()->get('coupon')['code'] ?? null;

        $tax = config('cart.tax');

        $discount = session()->get('coupon')['discount'] ?? 0;

        // Get New Values After Applied The Discount If There
        $new_subtotal = Cart::instance('default')->subtotal() - $discount;

        $new_subtotal = $new_subtotal >= 0 ? $new_subtotal : 0;

        $new_tax = $new_subtotal * $tax / 100;
        $new_tax = app_number_format($new_tax);

        $new_total = $new_subtotal + $new_tax;

        return collect([
            'discount_code' => $discount_code, 'discount' => $discount, 'new_subtotal' => $new_subtotal, 'new_tax' => $new_tax, 'new_total' => $new_total
        ]);
    }

}

/**
 * Application`s General Number Foramat
 */

if( ! function_exists('app_number_format') ) {

    function app_number_format($number) {

        return number_format($number, 2, '.', '');

    }

}
