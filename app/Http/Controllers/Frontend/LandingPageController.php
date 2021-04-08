<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $products = Product::where('quantity', '>', 0)->where('featured', true)->inRandomOrder()->take(8)->get();

        return view('frontend.landing_page', compact('products'));
    }
}
