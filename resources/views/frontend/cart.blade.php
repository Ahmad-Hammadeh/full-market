@extends('layouts.frontend.app')

@section('title', __('frontend.cart'))

@section('content')

<x-frontend.breadcrumbs>
    <i class="fa fa-angle-right"></i> <a href="{{ route('shop.index') }}">@lang('frontend.shop')</a>
</x-frontend.breadcrumbs>

<div class="cart-page section">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                @if(Cart::instance('default')->count() <= 0) <p class="message mb-4 h4">
                    @lang('frontend.no_items_in_your_cart')</p>

                    <div class="continue-shopping">
                        <a href="{{ route('shop.index') }}" class="btn btn-secondary">@lang('frontend.continue_shopping')</a>
                    </div>
                    {{-- ./cart-actions --}}

                    @else
                    <h4 class="items-count">{{ Cart::instance('default')->count() }} @lang('frontend.items_in_cart')
                    </h4>
                    <div class="cart-products">
                        <div class="products-table table-responsive">
                            <table class="table table-striped table-hover">
                                <tbody>
                                    @foreach( Cart::instance('default')->content() as $product )
                                    <tr>
                                        <td class="image">
                                            <img src="{{ get_image( $product->model->image ) }}"
                                                alt="{{ $product->model->name }}">
                                        </td>
                                        <td class="details">
                                            <p class="name"><a
                                                    href="{{ route('shop.show', $product->model->slug) }}">{{ $product->model->name }}</a>
                                            </p>
                                            <p class="price">@money( $product->model->price )</p>
                                        </td>
                                        <td class="cart-action">
                                            <form action="{{ route('cart.destroy', $product->rowId) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">@lang('frontend.remove')</button>
                                            </form>

                                            <form action="{{ route('cart.save_for_later', $product->rowId) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit">@lang('frontend.save_for_later')</button>
                                            </form>
                                        </td>
                                        <td class="quantity">
                                            <select data-rowId="{{ $product->rowId }}" data-quantity="{{ $product->model->quantity }}" data-name="{{ $product->model->name }}">
                                                @for ($i = 1; $i <= 5; $i++) <option value="{{ $i }}"
                                                    {{ $product->qty == $i ? 'selected': '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td class="subtotatal">
                                            @money( $product->subtotal() )
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- /.card-products --}}

                    <div class="cart-total">
                        <div class="description text-justify">@lang('frontend.short_lorem')</div>
                        <div class="total-table">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>@lang('frontend.subtotal')</td>
                                        <td class="sub-total">@money( Cart::subtotal() )</td>
                                    </tr>
                                    @if( session()->has('coupon') )
                                    <tr class="discount">
                                        <td>
                                            @lang('frontend.discount') ({{ session()->get('coupon')['code'] }}):
                                            <form action="{{ route('coupon.destroy') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">@lang('frontend.remove')</button>
                                            </form>
                                        </td>
                                        <td>-@money( $discount )</td>
                                    </tr>
                                    <tr class="new-sub-total">
                                        <td>@lang('frontend.new_subtotal')(<small>@lang('frontend.after_discount')</small>)
                                        </td>
                                        <td>@money( $new_subtotal )</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>@lang('frontend.tax')</td>
                                        <td class="tax">@money( $new_tax )</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>@lang('frontend.total')</td>
                                        <td class="total">@money( $new_total )</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    {{-- /.total-table --}}

                    @if( ! session()->has('coupon') )

                    <div class="have-code-container">
                        <a href="#" class="have-code">@lang('frontend.have_code')</a>
                        <div class="code-form">
                            <form action="{{ route('coupon.store') }}" method="POST">
                                @csrf
                                <input type="text" name="coupon_code" id="coupon_code">
                                <button type="submit">@lang('frontend.apply')</button>
                            </form>
                        </div>
                    </div>
                    {{-- /.have-code-container --}}

                    @endif

                    <div class="cart-actions">
                        <a href="{{ route('shop.index') }}" class="btn btn-secondary">@lang('frontend.continue_shopping')</a>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary">@lang('frontend.go_to_checkout')</a>
                    </div>
                    {{-- ./cart-actions --}}
                    @endif




                    @if(Cart::instance('save_for_later')->count() <= 0) <p class="message h4">
                        @lang('frontend.you_have_not_items_for_later')</p>
                        @else
                        <div class="for-later">
                            <h4 class="items-count">{{ Cart::instance('save_for_later')->count() }}
                                @lang('frontend.items_saved_for_later')</h4>
                            <div class="products-table table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        @foreach( Cart::instance('save_for_later')->content() as $product )
                                        <tr>
                                            <td class="image">
                                                <img src="{{ get_image( $product->model->image ) }}"
                                                    alt="{{ $product->model->name }}">
                                            </td>
                                            <td class="details">
                                                <p class="name"><a
                                                        href="{{ route('shop.show', $product->model->slug) }}">{{ $product->model->name }}</a>
                                                </p>
                                                <p class="price">@money( $product->model->price )</p>
                                            </td>
                                            <td class="cart-action">
                                                <form action="{{ route('cart.destroy', $product->rowId) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">@lang('frontend.remove')</button>
                                                </form>

                                                <form action="{{ route('cart.move_to_cart', $product->rowId) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit">@lang('frontend.move_to_cart')</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        {{-- ./for-later --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('extra-js')
<script src="{{ asset('js/cart.js') }}"></script>
@endpush
