@extends('layouts.base')

@section('content')
<h2 class="d-flex flex-row">
    <div class="col">Item #{{ $item->id }}</div>
    <div class="col-auto">
        <a class="btn btn-outline-primary" href="{{ route('items.edit', $item) }}">Edit</a>
        <a class="btn btn-outline-danger" href="#">Delete</a>
    </div>
</h2>

<ul class="dashed">
    <li>
        Created {{ $item->created->diffForHumans() }}
        @if($item->created < $item->updated)
        and updated {{ $item->created->diffForHumans() }}
        @endif
    </li>

    <li>
        Dataset:
        <a href="{{ route('datasets.show', $item->dataset) }}">
            {{ $item->dataset->name }}
        </a>
    </li>
</ul>

<p class="boxed lead">{{ $item->text }}</p>

<h3>Tags</h3>
<ul class="list-group border border-secondary rounded">
    @foreach($item->tags as $tag)
    <li class="list-group-item d-flex flex-row align-item-stretch">
        <a href="{{ route('tags.show', $tag) }}" style="flex-grow: 1">
            {{ $tag->name }}
        </a>

        <button class="btn btn-sm btn-outline-warning">Remove</button>
    </li>
    @endforeach
</ul>

<form action="{{ route('items.update', $item) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <div class="form-row align-items-stretch mt-2">
        <div class="col">
            <input
                type="text"
                class="form-control border border-secondary"
                name="new_tag"
                required
                autocomplete="off"
                placeholder="One or more tags to add, space-separated"
            >
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-success">Add</button>
        </div>
    </div>
</form>

<h3>Metadata</h3>
<ul class="list-group border border-secondary rounded">
    @foreach($item->metadata as $key => $value)
    <li class="list-group-item d-flex flex-row align-item-stretch">
        <div class="text-info">{{ $key }}:&nbsp;</div>
        <div style="flex-grow: 1">{{ $value }}</div>
        <button class="btn btn-sm btn-outline-primary">Edit</button>
        <button class="btn btn-sm btn-outline-warning ml-2">Remove</button>
    </li>
    @endforeach
</ul>

<form action="{{ route('items.update', $item) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <div class="form-row align-items-stretch mt-2">
        <div class="col">
            <input
                type="text"
                class="form-control border border-secondary"
                name="new_metadata_key"
                required
                autocomplete="off"
                placeholder="Key"
            >
        </div>
        <div class="col">
            <input
                type="text"
                class="form-control border border-secondary"
                name="new_metadata_value"
                required
                autocomplete="off"
                placeholder="Value"
            >
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-success">Add</button>
        </div>
    </div>
</form>
@endsection
