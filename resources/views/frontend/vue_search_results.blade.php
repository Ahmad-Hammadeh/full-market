@extends('layouts.frontend.app')

@section('title', __('frontend.search_results'))
@push('extra-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7.3.1/themes/reset-min.css"
    integrity="sha256-t2ATOGCtAIZNnzER679jwcFcKYfLlw01gli6F6oszk8=" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7.3.1/themes/algolia-min.css"
    integrity="sha256-HB49n/BZjuqiCtQQf49OdZn63XuKFaxcIHWf0HNKte8=" crossorigin="anonymous">
@endpush

@section('content')

<x-frontend.breadcrumbs>
    <i class="fa fa-angle-right"></i> <a href="{{ route('shop.index') }}">@lang('frontend.shop')</a>
</x-frontend.breadcrumbs>

<div class="search-page section">
    <div class="container">
        <h2 class="search-header">@lang('frontend.search_results')</h2>
        <instant-search></instant-search>

    </div>
</div>
@endsection

