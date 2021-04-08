<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Exception\CardErrorException;
use Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\Frontend\CheckoutRequest;
use App\Traits\PaymentTrait;

class CheckoutController extends Controller
{
    use PaymentTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Cart::instance('default')->count() > 0 ){

            if( request()->is('guest_checkout') && auth()->user() ){
                // Redirct The Loggen In User To Checkout Page
                return redirect()->route('checkout.index');

            }

            return view('frontend.checkout')->with([
                'discount' => with_discount()->get('discount'),
                'new_subtotal' => with_discount()->get('new_subtotal'),
                'new_tax' => with_discount()->get('new_tax'),
                'new_total' => with_discount()->get('new_total')
            ]);

        }else {

            return redirect()->route('landing-page');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {
        // Check If Stock Quatities Are Still Enough Befor Continue
        $product = $this->checkQuatitisAreStilEnough();
        if( ! empty( $product ) ){

            if( $product->quantity > 0 ){

                $error_message = __('frontend.quantity_no_longer_available', [ 'product_name' => $product->name, 'product_quantity' => $product->quantity ] );

            } else {

                $error_message = __('frontend.product_no_longer_available', [ 'product_name' => $product->name] );

            }
            return redirect()->route('cart.index')->withErrors( $error_message );

        }

        if( $request->payment_method === 'at_receiving' ){

            $this->make_order($request);

            return redirect()->route('checkout.finish')->with('success', __('frontend.order_completed_successfully'));

        } else if( $request->payment_method === 'credit_card' ) {

            $content = Cart::instance('default')->content()->map( function($item){
                return $item->model->slug . ', ' . $item->qty;
            } )->values()->toJson();

            try {

                $charge = Stripe::charges()->create([
                    'amount' => with_discount()->get('new_total'),
                    'currency' => 'USD',
                    'source' => $request->stripeToken,
                    'receipt_email' => $request->email,
                    'description' => 'Order',
                    'metadata' => [

                        // This Will Be Changed To orderID When Implement The DB In Saving Succeeded Order
                        'content' => $content,
                        'total_quantity' => Cart::instance('default')->count(),
                        'discount' => collect( with_discount()->get('discount') )->toJson()
                    ]
                ]);

                /*** Success The Charge Of the Online Card ***/

                $order = $this->make_order($request);

                $order->update([
                    'is_paid' => true,
                    'payment_method' => 'credit_card',
                ]);

                return redirect()->route('checkout.finish')->with('success', __('frontend.order_completed_successfully'));


            } catch (CardErrorException $th) {

                /*** Fail The Charge Of the Online Card ***/
                $this->addOrder($request, $th->getMessage());

                return redirect()->back()->withInput()->withErrors('warning!! ' . $th->getMessage());
            }

        }else {
            // Paypal Payment
            return redirect()->route('paypal', [$request]);
        }

    }

    /**
     * Show Finish Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function finish()
    {
        if( session()->has('success') ) return view('frontend.finish');
        else return redirect()->route('landing-page');
    }

}
