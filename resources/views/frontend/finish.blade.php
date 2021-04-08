<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Full Market | @yield('title', __('frontend.finish'))</title>

    <link href="/img/favicon.ico" rel="SHORTCUT ICON" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

</head>


<body class="@yield('body-class', '')">

<div class="finish container">
    <div class="finish-popup">
        <div class="correct-signal">
            <i class="fa fa-check fa-5x"></i>
        </div>
        <p>@lang("frontend.short_lorem")</p>
        <div class="finish-actions">
            <a href="{{route('landing-page')}}" class="btn btn-success btn-block">@lang("frontend.go_to_homepage")</a>
        </div>
    </div>
</div>

    <script src="{{asset('js/app.js') }}"></script>

</body>

</html>
