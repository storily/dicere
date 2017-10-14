@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title">Login</h2>
        <h6 class="card-subtitle mb-2 text-muted">
            To login, provide your email.
            We'll send you a magic link in an email that you'll have
            to click to complete the login.
        </h6>

        <form class="form-horizontal container-fluid" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="row">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-1">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>

                <div class="col">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Remember Me</label>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
