<?php

use App\Mail\OrderAdded;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Frontend'], function () {

    Route::get('/', 'LandingPageController@index')->name('landing-page');

    Route::get('/shop', 'ShopController@index')->name('shop.index');
    Route::get('/shop/{slug}', 'ShopController@show')->name('shop.show');
    Route::get('/search', 'ShopController@search')->name('shop.search');
    Route::get('/instance_search', 'ShopController@instance_search')->name('shop.instance_search'); // Vanila Js Instant Search
    Route::get('/vue_search', 'ShopController@vue_search')->name('shop.vue_search'); // Vue Js Instant Search


    // Cart Routes
    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::post('/cart', 'CartController@store')->name('cart.store');
    Route::patch('/cart/{rowId}', 'CartController@update')->name('cart.update');
    Route::delete('/cart/{rowId}', 'CartController@destroy')->name('cart.destroy');
    Route::post('/save_for_later/{rowId}', 'CartController@save_for_later')->name('cart.save_for_later');
    Route::post('/move_to_cart/{rowId}', 'CartController@move_to_cart')->name('cart.move_to_cart');

    // Coupon Routes
    Route::post('/coupon', 'CouponController@store')->name('coupon.store');
    Route::delete('/coupon', 'CouponController@destroy')->name('coupon.destroy');

    // Checkout Routes
    Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
    Route::get('/guest_checkout', 'CheckoutController@index')->name('guest_checkout.index');
    Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');
    Route::get('/finish', 'CheckoutController@finish')->name('checkout.finish');

    // Pay With Paypal Route
    Route::get('paypal', 'PaypalController@postPaymentWithpaypal')->name('paypal');
    Route::get('paypal_status', 'PaypalController@getPaymentStatus')->name('status');

    Route::group(['middleware' => 'auth'], function () {

        // My Profile Routes
        Route::get('/my_profile', 'UserController@edit')->name('user.edit');
        Route::patch('/my_profile', 'UserController@update')->name('user.update');

        // My Ordes Routes
        Route::get('/my_orders', 'OrderController@index')->name('order.index');
        Route::get('orders/{order}', 'OrderController@show')->name('order.show');

    });

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

