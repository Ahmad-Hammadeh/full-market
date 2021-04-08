@component('mail::message')
# Success adding order message

**Order ID:** {{ $order->id }}<br>
**Your email:** {{ $order->email }}<br>
**Your name:** {{ $order->name }}<br>
**Your total:** @money( $order->total )<br>

**Products Of The Order**

@component('mail::table')

| **Name**             | **Price**                 | **Quantity**                    |
| :------------------: | :-----------------------: | :-----------------------------: |
@foreach ($order->products as $product)
| {{ $product->name }} | @money( $product->price ) | {{ $product->pivot->quantity }} |
@endforeach

@endcomponent

@lang('backend.added_order')<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
