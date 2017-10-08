<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Dicere') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Crimson+Text" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                color: #333;
                font-family: 'Crimson Text', serif;
                background-color: #fff;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                min-height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .top-left {
                position: absolute;
                left: 10px;
                top: 18px;
            }

            .content {
                font-size: 1.2rem;
                max-width: 30em;
            }

            h1.title {
                color: #636b6f;
                font-weight: 100;
                font-size: 84px;
                text-align: center;
            }

            .content .links {
                text-align: center;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-family: 'Raleway', sans-serif;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            h1, h2, h3 {
                font-family: 'Raleway', sans-serif;
            }

            h2, h3 {
                font-weight: 600;
                margin-left: -1.5rem;
                margin-top: 2em;
            }

            h2::before {
                content: '›';
                margin-right: .7rem;
            }

            h3::before {
                content: '»';
                margin-right: .7rem;
            }

            h2 a, h3 a {
                color: inherit;
                text-decoration: none;
            }

            p a, table a {
                color: inherit;
            }

            code {
                font-size: 0.75em;
            }

            a[href^="#"] {
                text-decoration-style: dotted;
            }

            h2 {
                font-size: 1.5em;
                font-variant: small-caps;
                text-transform: lowercase;
            }

            h3 {
                font-size: 1em;
            }

            .cogitare, a.cogitare {
                color: #00D1B2;
            }

            table {
                border-collapse: collapse;
                text-align: left;
                width: 100%;
            }

            td, th {
                padding: 0.2em 1em;
                border: 1px solid black;
            }

            tbody th {
                font-family: Raleway, sans-serif;
                font-variant: small-caps;
                font-weight: 600;
            }

            thead {
                border-bottom-style: double;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="top-left links">
                <a href="{{ url('/') }}">Dicere</a>
                <a href="{{ url('/docs') }}">Docs</a>
                <a href="{{ url('/graphiql') }}">API</a>
                <a class="cogitare" href="https://cogitare.nz">Cogitare</a>
            </div>

            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ route('admin') }}">Admin</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                @yield('content')
            </div>
        </div>
    </body>
</html>
