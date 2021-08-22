<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

    
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
        <link href="{{ asset('css/card.css') }}" rel="stylesheet">
        <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
        <link href="{{ asset('css/btns.css') }}" rel="stylesheet">
        <link href="{{ asset('css/teacher-show.css') }}" rel="stylesheet">
        <link href="{{ asset('css/student-dashboard.css') }}" rel="stylesheet">
        <link href="{{ asset('css/box-style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased" dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="mt-3">

                @if($errors->any())
                    <center class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @foreach($errors->all() as $error)
                        <li class="text-danger">{{$error}}</li>
                    @endforeach
                    </center>
                 @endif
                 
                @if(session('status'))
                <center class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 alert alert-{{session('status','info')}}">
                   {{session('message')}}
                </center>
                @endif

                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <footer class="py-3">
            
        </footer>
    </body>
</html>
