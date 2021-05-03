
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-box">

            <a href="{{ route('landing-page') }}">{{ env('APP_NAME', 'Full Markrt') }}</a>

            {{ $slot }}

            @hasSection('title')
            <i class="fa fa-angle-right"></i> @yield('title')
            @endif

        </div>
        <div class="search-box">
            @include('layouts.frontend.partials.search')
            <auto-complete></auto-complete>
        </div>
    </div>
</div>

{{-- Alerts --}}
@include('layouts.frontend.partials.alerts')
