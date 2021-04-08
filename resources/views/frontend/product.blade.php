@extends('layouts.frontend.app')

@section('title', $product->name)

@section('content')

<x-frontend.breadcrumbs>
<i class="fa fa-angle-right"></i> <a href="{{ route('shop.index') }}">@lang('frontend.shop')</a>
</x-frontend.breadcrumbs>

<div class="product-page">
    <div class="product section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-image">
                        <img id="main-image" class="active" src="{{ get_image( $product->image ) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="row no-gutters align-items-start multiple-images">
                        <div class="col-6 col-sm-4 col-md-3">
                            <div class="image-container img-thumbnail selected">
                                <img src="{{ get_image( $product->image ) }}" alt="{{ $product->name }}">
                            </div>
                        </div>
                    @if ( $product->images )

                    @foreach ( json_decode( $product->images, true ) as $image )
                        <div class="col-6 col-sm-4 col-md-3">
                            <div class="image-container img-thumbnail">
                                <img src="{{ get_image( $image ) }}" alt="{{ $product->name }}">
                            </div>
                        </div>
                    @endforeach

                    @endif

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-description">
                        <h2 class="name">{{ $product->name }}</h2>
                        <small>{{ $product->details }}</small>
                        <span class="{{ $stock_class }}">{{ $stock_status }}</span>
                        <p class="price h2">@money( $product->price )</p>
                        <div class="discription text-justify">{!! $product->description !!}</div>

                        @if( $product->quantity > 0 )

                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <button type="submit" class="add-to-card btn btn-success btn-sm">add to cart <i class="fa fa-shopping-cart"></i></button>
                        </form>
                        @else

                        <button class="btn btn-success btn-sm" disabled>add to cart <i class="fa fa-shopping-cart"></i></button>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="similar-products section">
        <div class="container">
            <p class="section-desc">@lang('frontend.similar_products')</p>

            @if($similar_products->count() > 0 )

            <div class="row">

                @foreach($similar_products as $product)

                <a href="{{ route('shop.show', $product->slug) }}" class="col-6 col-md-4 col-lg-3">
                    <div class="similar-product">
                        <img class="img-fluid" src="{{ get_image( $product->image ) }}" alt="{{ $product->name }}">
                        <p class="name">{{ $product->name }}</p>
                        <p class="price">@money( $product->price )</p>
                    </div>
                </a>

                @endforeach

            </div>

            @else
                <h4>@lang('frontend.no_similar_products')</h4>
            @endif

        </div>
    </div>
</div>
@endsection

@push('extra-js')
<script src="{{ asset('js/product_gallery.js') }}"></script>
@endpush
