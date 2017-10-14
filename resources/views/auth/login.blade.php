@extends('layouts.base')

@section('content')
<h2>Login</h2>
<p class="text-muted">
    To login, provide the email you registered with. We’ll send you a “magic”
    link that you’ll have to click to complete the login.
</p>

<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email" class="control-label">Email address</label>
        <input
            id="email"
            type="email"
            class="form-control"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            placeholder="name@example.com"
        >

        @if ($errors->has('email'))
        <small class="form-text text-danger">{{ $errors->first('email') }}</small>
        @endif
    </div>

    <div class="form-row align-items-center">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="col-auto">
            <div class="form-check mb-2 mb-sm-0">
                <label class="form-check-label">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    Remember me
                </label>
            </div>
        </div>
    </div>
</form>
@endsection
