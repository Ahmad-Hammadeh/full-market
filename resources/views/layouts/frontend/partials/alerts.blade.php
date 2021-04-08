@if( session()->has('success') )
    <div class="container">
        <div class="alert alert-success mt-4">
            {{ session()->get('success') }}
        </div>
    </div>
@endif

@if( session()->has('error') )
    <div class="container">
        <div class="alert alert-danger mt-4">
            {{ session()->get('error') }}
        </div>
    </div>
@endif

@if( count($errors) > 0 )
    <div class="container">
        <ul class="list-unstyled mt-4">
            @foreach ($errors->all() as $error)

                <li class="alert alert-danger">{!! $error !!}</li>

            @endforeach
        </ul>
    </div>

@endif
