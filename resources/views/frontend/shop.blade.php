@extends('layouts.frontend.app')

@section('title', __('frontend.shop'))

@section('content')

<x-frontend.breadcrumbs />

<div class="shop section">
    <div class="container">
        <div class="show-by">
            <p>Show By:</p>
            <div class="row">
                <div class="col-6">
                    <div class="dropdown categories">
                        <span class="description">categories</span>
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="categories"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $category_name }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="categories">
                            @if( request()->has('category') )
                            <a class="dropdown-item" href="{{ route('shop.index') }}">@lang('frontend.featured')</a>
                            @endif
                            @foreach ($categories as $category)
                            @if( $category->slug === request('category') )
                            @continue
                            @endif
                            <a class="dropdown-item"
                                href="{{ route('shop.index', [ 'category' => $category->slug ]) }}">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="prices">
                        <span class="description">prices</span>
                        <a class="{{ isActive('sort', 'low_to_height') }}"
                            href="{{ route('shop.index', [ 'category' => request()->category, 'sort' => 'low_to_height' ]) }}">@lang('frontend.low_to_height')</a>
                        |
                        <a class="{{ isActive('sort', 'height_to_low') }}"
                            href="{{ route('shop.index', [ 'category' => request()->category, 'sort' => 'height_to_low' ]) }}">@lang('frontend.height_to_low')</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="products text-center">
            <div class="row">

                @forelse ($products as $product)

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card product">
                        <img class="card-img-top img" src="{{ get_image( $product->image ) }}"
                            alt="{{ $product->name }}">
                        <a href="{{ route('shop.show', $product->slug) }}"
                            class="card-title name">{{ $product->name }}</a>
                        <p class="card-text price">@money ( $product->price )</p>
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <button type="submit"
                                class="add-to-card btn btn-success btn-block btn-sm">@lang('frontend.add_to_cart') <i
                                    class="fa fa-shopping-cart"></i></button>
                        </form>
                    </div>
                </div>

                @empty

                <h4 class="section">@lang('frontend.no_products')</h4>

                @endforelse

            </div>
        </div>

        {{-- Pagination Links --}}
        {{ $products->withQueryString()->links() }}

    </div>
</div>
@endsection
