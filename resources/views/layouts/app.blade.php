<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ÉcoLocal</title>
        <link rel="icon" href="{{ asset('images/ecolocal-logo.png') }}" type="image/png">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <style>

            .mTM {
                padding-top: 3.5rem;
            }
            @media (min-width: 768px) {
                .mTM {
                    padding-top: 3.7rem;
                }
            }
            
            @media (min-width: 992px) {
                .mTM{
                    padding-top: 3.7rem;
                }
            }
        </style>
    </head>
    <body>
        @include('partials.navbar')
        <div class="d-flex flex-column min-vh-100  mTM">
            <div class="w-100 flex-grow-1">
                @yield('content')
            </div>

            @include('partials.footer')
        </div>
        

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
