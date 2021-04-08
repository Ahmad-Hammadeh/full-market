<?php

namespace App\Traits;

use App\Mail\OrderAdded;
use App\Model\Coupon;
use App\Model\Order;
use App\Model\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

trait PaymentTrait {
    /**
     * Set The Order With Payment Method At Receiving
     */
    public function make_order($request) {
        // Create New Recod In orders Table With Null Error
        $order = $this->addOrder($request);

        // Decrease The Quantities Of Cart`s Products
        $this->decreaseQuantity();

        // Mark The Kullaned Coupon As "Used"
        Coupon::where('code', session('coupon')['code'])->update([
            'used' => true
        ]);

        // Send Success Added Order Email
        Mail::send( new OrderAdded( $order ) );

        Cart::instance('default')->destroy(); // Clear The Shopping Card
        session()->forget('coupon'); // Clear The Discount

        return $order;
    }

    /**
     * Add New Record To orders Table In Success, Fail Charge The Online Card Cases
     */
    private function addOrder($request, $error= null)
    {
        // Create New Record In orders Table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'email' => $request->email,
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postalcode' => $request->postalcode,
            'phone' => $request->phone,
            'name_on_card' => $request->name_on_card,
            'discount' => with_discount()->get('discount'),
            'discount_code' => with_discount()->get('discount_code'),
            'subtotal' => with_discount()->get('new_subtotal'),
            'tax' => with_discount()->get('new_tax'),
            'total' => with_discount()->get('new_total'),
            'error' => $error
        ]);

        // Create New Recods In order_product Pivot Table
        foreach( Cart::instance('default')->content() as $item ){

            $order->products()->attach( $item->model->id, [ 'quantity' => $item->qty ] );

        }

        return $order;
    }

    /**
     * Decrease The Quantities Of Cart`s Products Function
     */
    private function decreaseQuantity()
    {
        foreach (Cart::instance('default')->content() as $item) {

            $product = Product::find($item->model->id);

            $product->update([
                'quantity' => $product->quantity - $item->qty
            ]);

        }
    }

    /**
     * Check If The Stock Quantities Are Still Enough For ordering Quantities Function
     * This Function Check That After Adding Products To The Card Against Changing The Stock Qountites "For Some Reasons"
     * like Manual Changing The Stock Qountites By Admin, Or Changing The Stock Qountites By Another customer
     * After That "This Customer Has Been Added The Products To The Cart"
     */
    private function checkQuatitisAreStilEnough()
    {
        foreach (Cart::instance('default')->content() as $item) {

            $product = Product::find($item->model->id);

            if( $product->quantity < $item->qty ){

                return $product;

            }

        }

    }
}
