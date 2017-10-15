@extends('layouts.base')

@section('content')
@include('shared.admin-nav')

<h2 class="d-flex flex-row">
    <div class="col">Edit item #{{ $item->id }}</div>
    <div class="col-auto">
        <a class="btn btn-outline-primary" href="{{ route('items.show', $item) }}">Exit</a>
        <a class="btn btn-outline-danger" href="#">Delete</a>
    </div>
</h2>

<form action="{{ route('items.update', $item) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <div class="form-group">
        <label for="item-text" class="control-label">Item text</label>
        <textarea
            id="item-text"
            class="form-control item-input"
            style="min-height: 10rem"
            name="text"
            required
            autofocus
            autocomplete="off"
        >{{ $item->text }}</textarea>
    </div>

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
@endsection
