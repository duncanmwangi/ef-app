<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta name="description" content="{{ config('app.name', 'Laravel') }}">

    <base href="{{ asset('') }}" rel="stylesheet">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <!-- Styles -->

    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 



</head>

<body>
    <div class="app-container body-tabs-shadow fixed-header fixed-sidebar">
         @include('layouts.header.base')
         <div class="app-main">
            @include('layouts.sidebar')
            <div class="app-main__outer">
                <div class="app-main__inner">
                    @include('layouts.pageTitle')
                    <div>
                        <div class="row">
                            @yield('content')
                        </div>
                    </div>
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('assets/scripts/main.js') }}"></script>
   {{--  <script src="{{ asset('js/app.js') }}"></script>  --}}
   <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

@yield('scripts')

</body>
</html>