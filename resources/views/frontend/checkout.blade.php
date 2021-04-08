@extends('layouts.frontend.app')

@section('title', __('frontend.checkout'))

@section('content')
<div class="checkout section">
    <div class="container">
        <h1>@lang("frontend.checkout")</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="personal-details">
                    <h2 class="h5">@lang('frontend.billing_details')</h2>
                    <form action="{{ route('checkout.store') }}" method="POST" method="POST" id="payment-form">
                        @csrf
                        <div class="form-group">
                            <label for="email">@lang('frontend.email')</label>
                            <input type="email" id="email" class="form-control" name="email"
                                value="{{ auth()->user() ? auth()->user()->email: old('email') }}" required
                                {{ auth()->user() ? 'readonly': '' }}>
                        </div>
                        <div class="form-group">
                            <label for="name">@lang('frontend.name')</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="address">@lang('frontend.address')</label>
                            <input type="text" id="address" class="form-control" name="address"
                                value="{{ old('address') }}" required>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="city">@lang('frontend.city')</label>
                                <input type="text" id="city" class="form-control" name="city" value="{{ old('city') }}"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="province">@lang('frontend.province')</label>
                                <input type="text" id="province" class="form-control" name="province"
                                    value="{{ old('province') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="postalcode">@lang('frontend.postalcode')</label>
                                <input type="text" id="postalcode" class="form-control" name="postalcode"
                                    value="{{ old('postalcode') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">@lang('frontend.phone')</label>
                                <input type="text" id="phone" class="form-control" name="phone"
                                    value="{{ old('phone') }}" required>
                            </div>
                            {{-- /.row --}}
                        </div>

                        <div class="payment-methods">
                            <h2 class="h5">@lang('frontend.payments_details')</h2>

                            {{-- payment method --}}
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                        href="#at_receiving">@lang('frontend.at_receiving')</a><input type="radio" name="payment_method" value="at_receiving" checked></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                        href="#credit_card" data-payment="credit_card">@lang('frontend.credit_card')</a><input type="radio" name="payment_method" value="credit_card"></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab"
                                        href="#paypal">@lang('frontend.pay_with_paypal')</a><input type="radio" name="payment_method" value="pay_with_paypal"></li>
                            </ul>

                            <div class="tab-content">
                                <div id="at_receiving" class="tab-pane container active">
                                    @lang('frontend.at_receiving')
                                </div>
                                <div id="credit_card" class="tab-pane container fade">
                                    <x-frontend.card/>
                                </div>
                                <div id="paypal" class="tab-pane container fade">
                                    @lang('frontend.pay_with_paypal')
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="order-finish"
                            class="btn btn-success btn-block">@lang('frontend.finish')</button>
                    </form>
                </div>
            </div>
            {{-- /.col-md-6 --}}

            <div class="offset-md-1 col-md-5">
                <div class="order-list">
                    <div class="products-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>@lang('frontend.name_and_price')</th>
                                    <th>@lang('frontend.quantity')</th>
                                    <th>@lang('frontend.subtotal')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach (Cart::instance('default')->content() as $product)

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
                                    <td class="quantity">
                                        <span>{{ $product->qty }}</span>
                                    </td>
                                    <td class="subtotatal">
                                        @money( $product->subtotal() )
                                    </td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="total-table">
                        <table>
                            <tbody>
                                <tr class="sub-total">
                                    <td>@lang('frontend.subtotal')</td>
                                    <td>@money( Cart::subtotal() )</td>
                                </tr>

                                @if( session()->has('coupon') )
                                <tr class="discount">
                                    <td>
                                        @lang('frontend.discount') ({{ session()->get('coupon')['code'] }}):
                                    </td>
                                    <td>-@money( $discount )</td>
                                </tr>
                                <tr class="new-sub-total">
                                    <td>@lang('frontend.new_subtotal')(<small>@lang('frontend.after_discount')</small>)
                                    </td>
                                    <td>@money( $new_subtotal )</td>
                                </tr>
                                @endif

                                <tr class="tax">
                                    <td>@lang('frontend.tax') ({{ config( 'cart.tax' ) }}%)</td>
                                    <td>@money( $new_tax )</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="total">
                                    <td>@lang('frontend.total')</td>
                                    <td>@money( $new_total )</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            {{-- /.col-md-5 --}}
        </div>
    </div>
</div>
@endsection

@push('extra-js')
<script>
    let paymentLinks = document.querySelectorAll('.payment-methods .nav-link'),
        nameOnCard = document.querySelector('#name_on_card'),
        paymentForm = document.getElementById('payment-form');

    paymentLinks.forEach( paymentLink => {

        paymentLink.addEventListener( 'click', function() {

            this.nextElementSibling.click();

            if(this.dataset.payment != 'credit_card'){

                if( paymentForm.classList.contains('credit_card') ){

                    nameOnCard.removeAttribute('required');
                    nameOnCard.setAttribute('disabled', 'disabled');

                    card.unmount(); // Definatoin The Card Variable Is From Stripe

                    paymentForm.classList.remove('credit_card');
                }

            } else {

                if( ! paymentForm.classList.contains('credit_card') ){

                    nameOnCard.setAttribute('required', 'required');
                    nameOnCard.removeAttribute('disabled');

                    card.mount("#card-element");

                    paymentForm.classList.add('credit_card');

                }

            }

        } );

    } );
</script>
@endpush
