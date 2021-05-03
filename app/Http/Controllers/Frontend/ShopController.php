<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 12;

        if( request()->has('category') ){ // Case There Is Category Has Been Selected

            if( request()->has('sort') ){

                $order = request('sort') === 'low_to_height' ? 'asc': 'desc';

                $products = Product::where('quantity', '>', 0)->with('categories')->whereHas( 'categories', function($query){

                    $query->where('slug', request()->category);

                } )->orderBy('price', $order)->paginate($pagination);

            }else{

                $products = Product::where('quantity', '>', 0)->with('categories')->whereHas( 'categories', function($query){

                    $query->where('slug', request()->category);

                } )->paginate($pagination);

            }

            $category_name = optional( Category::where('slug', request()->category)->first() )->name;

        }else{ // Case No Category Is Selected

            if( request()->has('sort') ){

                $order = request('sort') === 'low_to_height' ? 'asc': 'desc';

                $products = Product::where('quantity', '>', 0)->where('featured', true)->inRandomOrder()->orderBy('price', $order)->paginate($pagination);

            }else{

                $products = Product::where('quantity', '>', 0)->where('featured', true)->inRandomOrder()->paginate($pagination);

            }

            $category_name = __('frontend.featured');

        }

        $categories = Category::all();

        return view('frontend.shop', compact('products', 'categories', 'category_name'));
    }

    /**
     * Display the specified resource.
     *
     * @param  str  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // $similar_products = Product::whereIn('category_id', $product->categories()->pluck('id')->toArray())->where('slug', '!=', $slug)->inRandomOrder()->take(8)->get();
        $similar_products = Product::inRandomOrder()->take(8)->get(); // For test

        if( $product->quantity > setting('site.stock_threshold') ) {
            $stock_status = "In stock";
            $stock_class = 'badge badge-success';
        }

        else if( $product->quantity > 0 && $product->quantity < setting('site.stock_threshold') ) {
            $stock_status = "Low stock";
            $stock_class = 'badge badge-warning';
        }

        else {
            $stock_status = __('frontend.not_available');
            $stock_class = 'badge badge-danger';
        }

        return view('frontend.product', compact('product', 'similar_products', 'stock_status', 'stock_class'));
    }

    // /**
    //  * Show the search resaults.
    //  *
    //  * @param  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function search(Request $request)
    // {
    //     $request->validate([
    //         'search' => 'required|min:3'
    //     ]);

    //     // $products = Product::where('name', 'like', "%$request->search%")
    //     //                     ->orWhere('details', 'like', "%$request->search%")
    //     //                     ->orWhere('description', 'like', "%$request->search%")->paginate(10);

    //     $products = Product::search($request->search)->paginate(10);

    //     return view('frontend.search_results', compact('products'));
    // }

    /**
     * Show the Instance Search resaults.
     * Using Vanila Js
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function instance_search()
    {
        return view('frontend.instance_search_results');
    }

    // /**
    //  * Show the Instance Search resaults.
    //  * Using Vue Js
    //  *
    //  * @param  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function vue_search()
    // {
    //     return view('frontend.vue_search_results');
    // }
}
