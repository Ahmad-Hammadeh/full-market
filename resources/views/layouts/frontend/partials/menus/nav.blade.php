<ul class="navbar-nav">

    @foreach($items as $menu_item)
    <li class="nav-item">
        <a class="nav-link" href="{{ $menu_item->link() }}">

            {{ $menu_item->title }}

            @if ( $menu_item->title === __('frontend.cart') )

            @if(Cart::instance('default')->count() > 0 )

            <span class="cart-count">{{ Cart::instance('default')->count() }}</span>

            @endif

            @endif

        </a>
    </li>
    @endforeach

    @guest

    <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">@lang('frontend.register')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">@lang('frontend.login')</a>
    </li>

    @else

    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.edit') }}">
            @lang('frontend.my_profile')
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
            @lang('frontend.logout')
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
    @endguest

</ul>
