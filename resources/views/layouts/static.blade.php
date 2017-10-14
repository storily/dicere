@extends('layouts.base')

@section('body')
<body class="page-static">
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
@endsection
