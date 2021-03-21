<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
        <link href="{{ asset('css/card.css') }}" rel="stylesheet">
        <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
        <link href="{{ asset('css/btns.css') }}" rel="stylesheet">
        <link href="{{ asset('css/teacher-show.css') }}" rel="stylesheet">
        <link href="{{ asset('css/student-dashboard.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body  dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">
        <div class="text-gray-900">
            {{ $slot }}
        </div>
    </body>
</html>
