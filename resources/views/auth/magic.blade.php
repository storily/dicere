@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Magic Link</div>

                <div class="panel-body">
                    <p>Magic link sent to <b>{{$email}}</b>! Go check your email.</p>
                    <p class="muted">You can close this page.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
