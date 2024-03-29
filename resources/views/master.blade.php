<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        @yield('extrastyles') 
        <!-- Latest compiled and minified CSS & JS -->
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script><!--Gets Chart-->
    </head>
    <body>
        <div id="app">
            @include('layouts.app')
            @if(session('success'))
                @include('shared.success')
            @endif
            @yield('content')
        </div>

        @yield('pagescript') 
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>