<nav class="main-nav navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand flex-row" href="{{ route('landing-page') }}">{{ env('APP_NAME', 'Full Markrt') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        @if( ! request()->is('checkout') && ! request()->is('guest_checkout') )

        <div class="collapse navbar-collapse flex-row-reverse" id="navbarNav">
          {{ menu('nav', 'layouts.frontend.partials.menus.nav') }}
        </div>

        @endif

    </div>
  </nav>

