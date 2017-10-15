<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Dicere') }}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('styles')
    </head>

    <body class="@yield('body-class')">
        <nav class="navbar">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Dicere') }}</a>
            <div class="lightswitch"></div>

            <button
                class="navbar-toggler"
                type="button"
                data-target="#nav-menu"
                data-toggle="collapse"
                aria-controls="nav-menu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav-menu">
                <ul class="navbar-nav">
                    @section('nav-left')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/docs') }}">Docs</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/graphiql') }}">API</a>
                    </li>
                    @show

                    <li class="nav-item">
                        <a class="nav-link cogitare" href="https://cogitare.nz">Cogitare</a>
                    </li>
                </ul>

                <div class="lightswitch"></div>
                <script src="{{ asset('js/lightswitch.js') }}"></script>

                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link loginout" href="{{ route('login') }}">Login</a>
                        </li>
                    @else
                        @yield('nav-right')

                        <li class="nav-item">
                            <a class="nav-link" href="/admin">Admin</a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link loginout"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"
                            >
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" hidden>
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <div class="content container">
            @yield('content')
        </div>

        <script async src="{{ asset('js/bootstrap.js') }}"></script>
        @yield('scripts')
    </body>
</html>
