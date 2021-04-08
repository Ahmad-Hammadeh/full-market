@extends('layouts.frontend.app')

@section('title', __('frontend.search_results'))

@section('content')

<x-frontend.breadcrumbs>
<i class="fa fa-angle-right"></i> <a href="{{ route('shop.index') }}">@lang('frontend.shop')</a>
</x-frontend.breadcrumbs>

<div class="search-page section">
    <div class="container">
        <h2 class="search-header">@lang('frontend.search_resaults')</h2>
        @if( $products->count() > 0 )
        <small class="search-count">{{ $products->total() }} @lang('frontend.result_s')</small>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>@lang('frontend.name')</th>
                        <th>@lang('frontend.details')</th>
                        <th>@lang('frontend.description')</th>
                        <th>@lang('frontend.price')</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($products as $product)
                        <tr>
                            <td><a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a></td>
                            <td>{{ Str::limit( $product->details, 70, '...' )  }}</td>
                            <td>{{ Str::limit( $product->description, 90, '...' )  }}</td>
                            <td>@money( $product->price )</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        {{ $products->withQueryString()->links() }}

        @else

        <p class="message h4">@lang('frontend.no_results_for', [ 'search' => request()->search ])</p>

        @endif
    </div>
</div>
@endsection
