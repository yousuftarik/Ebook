<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <title>
            @yield('title', 'Gronthik')
        </title>

        @include('backend.partials.styles')
        <!-- Fonts -->
       

        
    </head>
    <body>
        <div class="container-scroller">

            @include('backend.partials.messages')

            @yield('content')



            {{-- @include('backend.partials.footer') --}}

            @include('backend.partials.scripts')
            @yield('scripts')
        
        </div>
    </body>
</html>
