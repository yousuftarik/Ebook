    <!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta id="token" name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{asset('https://www.jqueryscript.net/css/jquerysctipttop.css')}}" rel="stylesheet" type="text/css">
        <script src="{{asset('http://code.jquery.com/ui/1.12.1/jquery-ui.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css')}}">
        <link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')}}">
        <script src = "{{asset('https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js')}}"></script>
        <script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js')}}"></script>
        <script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js')}}"></script>
         <title>
            @yield('title', 'Gronthik')
        </title>

        @include('backend.partials.styles')
        <!-- Fonts -->



    </head>

    <body>
        <div class="container-scroller">

            @include('backend.partials.nav')
            <div class="main-panel">
                <div class="content-wrapper" id="app">
                    @include('backend.partials.messages')

                    @yield('content')

                </div>

            </div>

            {{-- @include('backend.partials.footer') --}}
        </div>
        </div>

        @include('backend.partials.scripts')

        @yield('scripts')


    </body>

    </html>