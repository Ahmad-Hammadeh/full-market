<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.cart')->with([
            'discount' => with_discount()->get('discount'),
            'new_subtotal' => with_discount()->get('new_subtotal'),
            'new_tax' => with_discount()->get('new_tax'),
            'new_total' => with_discount()->get('new_total')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $duplicated_product = Cart::search(function($cartItem, $rowId) use($request) {
            return $cartItem->id === $request->id;
        });

        $duplicated_save_for_later = Cart::instance('save_for_later')->search(function($cartItem, $rowId) use($request) {
            return $cartItem->id === $request->id;
        });

        if( $duplicated_product->isNotEmpty() || $duplicated_save_for_later->isNotEmpty()){

            return redirect()->back()->withErrors('warning!! ' . __('frontend.product_added_previously'));

        }else{

            Cart::instance('default')->add( $request->id, $request->name, 1, $request->price )
            ->associate('App\Model\Product');
            return redirect()->route('cart.index')->with('success', __('frontend.product_added_successfully'));

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rowId)
    {
        $validator = Validator::make($request->all(),[
            'qty' => 'required|integer|between:1,5|max:' . $request->quantity
        ], [
            'qty.max' => 'It can not be more than the available quantity of "' . $request->name . '" which is now ' . $request->quantity .' !'
        ], [
            'qty' => __('frontend.quantity')
        ]);

        if( $validator->fails() ){

            session()->flash('errors', $validator->errors());
            return response()->json(['success' => false], 400);

        }else{

            Cart::update($rowId, $request->qty);

            session()->flash('success', __('frontend.quantity_updated_successfully'));
            return response()->json(['success' => true], 200);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        $default_cart = Cart::instance('default')->search(function($cartItem, $itemRowId) use ($rowId) {
            return $itemRowId === $rowId;
        });

        $later_cart = Cart::instance('save_for_later')->search(function($cartItem, $itemRowId) use ($rowId) {
            return $itemRowId === $rowId;
        });

        if( $default_cart->isNotEmpty() ) {

            Cart::instance('default')->remove($rowId);

        } elseif( $later_cart->isNotEmpty() ) {

            Cart::instance('save_for_later')->remove($rowId);

        }

        return redirect()->back()->with('success', __('frontend.product_removed_from_cart'));
    }

    /**
     * Save a created resource in save for later cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save_for_later($rowId)
    {
        $product = Cart::instance('default')->get($rowId);

        Cart::instance('default')->remove($rowId);

        Cart::instance('save_for_later')->add( $product->id, $product->name, 1, $product->price )
                ->associate('App\Model\Product');
            return redirect()->route('cart.index')->with('success', __('frontend.product_saved_for_later_successfully'));
    }

    /**
     * Move a saved for later resource to default shopping cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function move_to_cart($rowId)
    {

        $product = Cart::instance('save_for_later')->get($rowId);

        Cart::instance('save_for_later')->remove($rowId);

        Cart::instance('default')->add( $product->id, $product->name, 1, $product->price )
                ->associate('App\Model\Product');
            return redirect()->route('cart.index')->with('success', __('frontend.product_moved_to_cart_successfully'));

    }
}
