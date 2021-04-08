@extends('layouts.frontend.app')

@section('title', __('frontend.my_orders'))

@section('content')
<x-frontend.breadcrumbs />

<div class="my-orders section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul class="user-menu">
                    <li><a href="{{ route('user.edit') }}">@lang('frontend.my_profile')</a></li>
                    <li><a class="active" href="{{ route('order.index') }}">@lang('frontend.my_orders')</a></li>
                </ul>
            </div>
            <div class="col-md-9">

            @if ( $orders->count() > 0 )

                <h2 class="orders-count h5">@lang('frontend.orders_count') <strong>{{ $orders->count() }}</strong></h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>@lang('frontend.order_id')</th>
                                <th>@lang('frontend.total')</th>
                                <th>@lang('frontend.date')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($orders as $order)

                            <tr class="order" data-id="{{ $order->id }}">
                                <td>{{ $order->id }}</td>
                                <td>@money( $order->total )</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

            @else

                <h4 class="section">@lang('frontend.you_have_no_orders')</h4>

            @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('extra-js')

<script>

let orders = document.querySelectorAll('.my-orders .order');

orders.forEach(order => {

    order.addEventListener('click', function() {
        window.location.href = window.location.origin + '/orders/' + order.dataset.id;
    });

});

</script>

@endpush
