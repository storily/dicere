@extends('layouts.base')

@section('content')
@if (session('status'))
    <div class="alert alert-success mb-4">
        {{ session('status') }}
    </div>
@endif

<h2>
    Kia ora!
    <small>{{ Auth::user()->email }}</small>
</h2>
@endsection
