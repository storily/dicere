@extends('layouts.base')

@section('content')
<h2>Register</h2>
<p class="text-muted">
    You need an invite code to get in.
</p>

<form method="POST" action="{{ route('register') }}">
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

        <small class="form-text">Login is through email only, so make sure to enter it correctly!</small>

        @if ($errors->has('email'))
        <small class="form-text text-danger">{{ $errors->first('email') }}</small>
        @endif
    </div>

    <div class="form-group {{ $errors->has('invite') ? 'has-error' : '' }}">
        <label for="invite" class="control-label">Invite code</label>
        <input
            id="invite"
            type="text"
            class="form-control"
            name="invite"
            value="{{ old('invite') }}"
            required
        >

        <small class="form-text">Take care: invite codes are case-sensitive and single-use.</small>

        @if ($errors->has('invite'))
        <small class="form-text text-danger">{{ $errors->first('invite') }}</small>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
</form>
@endsection
