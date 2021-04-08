@extends('layouts.frontend.app')

@section('title', __('frontend.landing_page'))

@section('content')

@include('client_side.lang')

<div class="landin-page">
    <header class="header section">
        <div class="container">
            <div class="text-container">
                <h1>{{ env('APP_NAME', 'Full Market') }}</h1>
                <p>@lang('frontend.short_lorem')</p>
                <div class="buttons-container">
                    <a href="#">@lang('frontend.learn_more')</a>
                    <a href="#">@lang('frontend.Linked_in')</a>
                </div>
            </div>
            <div class="img-container">
                <img src="{{ asset('storage/general/header.webp') }}" alt="header">
            </div>
        </div>
    </header>
    {{-- /.header --}}
    <section class="random-products section text-center">
        <div class="container">
            <h2 class="section-title">{{ env('APP_NAME', 'Full Market') }}</h2>
            <p class="section-desc text-justify">@lang('frontend.medium_lorem')</p>

        @if($products->count() > 0)

            <div class="buttons-container">
                <a href="#">@lang('frontend.featured')</a>
                <a href="#">@lang('frontend.on_sale')</a>
            </div>
            <div class="products">
                <div class="row">

                    @foreach($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card product">
                            <img class="card-img-top img" src="{{ get_image( $product->image ) }}" alt="{{ $product->name }}">
                            <a href="{{ route('shop.show', $product->slug) }}" class="card-title name">{{ $product->name }}</a>
                            <p class="card-text price">@money( $product->price )</p>
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <button type="submit" class="add-to-card btn btn-success btn-block btn-sm">@lang('frontend.add_to_cart') <i class="fa fa-shopping-cart"></i></button>
                            </form>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            <div class="buttons-container">
                <a href="{{ route('shop.index') }}">@lang('frontend.view_more_products')</a>
            </div>

        @else
            <h4>@lang('frontend.no_products')</h4>
        @endif

        </div>
    </section>
    {{-- /.random-products --}}

    <blog-posts></blog-posts>

    <section class="customers-says section text-center">
        <div class="container">
            <h2 class="section-title">@lang('frontend.customers_saying')</h2>
            <p class="section-desc text-justify">@lang('frontend.medium_lorem')</p>
            <div class="row">
                <div class="person-container col-md-6 col-lg-4">
                    <div class="card person">
                        <img src="{{ asset('storage/general/header.webp') }}" class="rounded-circle img-thumbnail" alt="customer avatar">
                        <div class="card-body">
                          <h5 class="card-title">Samer Noor</h5>
                          <p class="card-text text-justify">@lang('frontend.medium_lorem')</p>
                        </div>
                      </div>
                </div>
                <div class="person-container col-md-6 col-lg-4">
                    <div class="card person">
                        <img src="{{ asset('storage/general/header.webp') }}" class="rounded-circle img-thumbnail" alt="customer avatar">
                        <div class="card-body">
                          <h5 class="card-title">Samer Noor</h5>
                          <p class="card-text text-justify">@lang('frontend.medium_lorem')</p>
                        </div>
                      </div>
                </div>
                <div class="person-container col-md-6 col-lg-4">
                    <div class="card person">
                        <img src="{{ asset('storage/general/header.webp') }}" class="rounded-circle img-thumbnail" alt="customer avatar">
                        <div class="card-body">
                          <h5 class="card-title">Samer Noor</h5>
                          <p class="card-text text-justify">@lang('frontend.medium_lorem')</p>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </section>
    {{-- /.customers-says --}}
</div>
@endsection
