<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth()->user()->orders()->with('products')->get();

        return view('frontend.my_orders', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if( auth()->user()->id != $order->user_id ) {
            return back()->withErrors(__('frontend.you_have_no_permissions_to_show_this_page'));
        }

        $products = $order->products;
        return view('frontend.order', compact('order', 'products'));
    }

}
