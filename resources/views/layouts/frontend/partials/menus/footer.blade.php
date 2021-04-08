{{-- <ul class="socials-links">
    <li><a href="#"><i class="fa fa-globe"></i></a></li>
    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
    <li><a href="#"><i class="fa fa-feed"></i></a></li>
</ul> --}}

<ul class="socials-links">
    @foreach($items as $menu_item)
        <li>
            <a href="{{ $menu_item->link() }}">
                <i class="fa {{ $menu_item->title }}"></i>
            </a>
        </li>
    @endforeach
</ul>
