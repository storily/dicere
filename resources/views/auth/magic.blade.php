@extends('layouts.base')

@section('content')
<h2>Magic link</h2>
<p>Magic link sent to <b>{{ $email }}</b>! Go check your email.</p>
<p class="text-muted">You can close this page.</p>
@endsection
