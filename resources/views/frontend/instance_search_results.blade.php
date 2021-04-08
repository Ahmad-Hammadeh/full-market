@extends('layouts.frontend.app')

@section('title', __('frontend.search_results'))
@push('extra-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7.3.1/themes/reset-min.css" integrity="sha256-t2ATOGCtAIZNnzER679jwcFcKYfLlw01gli6F6oszk8=" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7.3.1/themes/algolia-min.css" integrity="sha256-HB49n/BZjuqiCtQQf49OdZn63XuKFaxcIHWf0HNKte8=" crossorigin="anonymous">
@endpush

@section('content')

<x-frontend.breadcrumbs>
<i class="fa fa-angle-right"></i> <a href="{{ route('shop.index') }}">@lang('frontend.shop')</a>
</x-frontend.breadcrumbs>

<div class="search-page section">
    <div class="container">
        <h2 class="search-header">@lang('frontend.search_results')</h2>
        <div class="row">
            <div class="col-md-3">
                <div id="instance-search-results" class="search-box">
                    {{-- Here Will Be Search Box --}}
                </div>
                <div id="stats">
                    {{-- Here Will Be Search Stats --}}
                </div>
                <div id="refinement-list">
                    {{-- Here Will Be Search Refinement List --}}
                </div>
            </div>
            <div class="col-md-9">
                <div id="hits">
                    {{-- Here Will Be Search Result --}}
                </div>
                <div id="pagination">
                    {{-- Here Will Be Search Result Pagination Links --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('extra-js')
<script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.5.1/dist/algoliasearch-lite.umd.js" integrity="sha256-EXPXz4W6pQgfYY3yTpnDa3OH8/EPn16ciVsPQ/ypsjk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/instantsearch.js@4.8.3/dist/instantsearch.production.min.js" integrity="sha256-LAGhRRdtVoD6RLo2qDQsU2mp+XVSciKRC8XPOBWmofM=" crossorigin="anonymous"></script>
<script src="{{ asset('js/instanceSearch.js') }}"></script>
@endpush
