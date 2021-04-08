@extends('layouts.frontend.app')

@section('title', __('frontend.order_details'))

@section('content')
<x-frontend.breadcrumbs />

<div class="order-details section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul class="user-menu">
                    <li><a href="{{ route('user.edit') }}">@lang('frontend.my_profile')</a></li>
                    <li><a class="active" href="{{ route('order.index') }}">@lang('frontend.my_orders')</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <h2 class="order-head h5">@lang('frontend.order_details')</h2>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('frontend.order_id')</th>
                                <th>@lang('frontend.email')</th>
                                <th>@lang('frontend.name')</th>
                                <th>@lang('frontend.address')</th>
                                <th>@lang('frontend.city')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="order" data-id="{{ $order->id }}">
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->city }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('frontend.subtotal')</th>
                                <th>@lang('frontend.discount')</th>
                                <th>@lang('frontend.tax')</th>
                                <th>@lang('frontend.total')</th>
                                <th>@lang('frontend.date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="order" data-id="{{ $order->id }}">
                                <td>@money( $order->subtotal )</td>
                                <td>@money( $order->discount )</td>
                                <td>@money( $order->tax )</td>
                                <td>@money( $order->total )</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="h5">
                    @lang('frontend.products_of_this_order'): <small>{{ $order->products()->count() }}</small>
                </div>

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
                            @foreach ($products as $product)

                            <tr>
                                <td class="image">
                                    <img src="{{ get_image( $product->image ) }}"
                                        alt="{{ $product->name }}">
                                </td>
                                <td class="details">
                                    <p class="name">
                                        <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                                    </p>
                                    <p class="price">@money( $product->price )</p>
                                </td>
                                <td class="quantity">
                                    <span>{{ $product->pivot->quantity }}</span>
                                </td>
                                <td class="subtotatal">
                                    @money( $product->price * $product->pivot->quantity )
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

