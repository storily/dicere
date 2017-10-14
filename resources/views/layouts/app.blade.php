@extends('layouts.base')

@section('nav-right')
    @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Register</a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile') }}">{{ Auth::user()->name }}</a>
        </li>

        <li class="nav-item">
            <a
                class="nav-link"
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
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
