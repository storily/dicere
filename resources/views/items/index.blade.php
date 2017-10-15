@extends('layouts.base')

@section('content')
@include('shared.admin-nav')

<h2 class="mb-4">
    {{ $items->count }} Items
</h2>

<table>
    <thead>
        <tr>
            <th>Excerpt</th>
            <th>Tags</th>
        </tr>
    </thead>

    <tbody>
        @foreach($items->pages as $item)
        <tr>
            <td><a href="{{ route('items.show', $item) }}" class="no-frills">
                {{ substr($item->text, 0, 60) }}{{ strlen($item->text) > 60 ? '…' : '' }}
            </a></td>
            <td>{!! $item->tags()->get()->map(function ($tag) {
                return '<a href="'.route('tags.show', $tag).'">'.e($tag->name).'</a>';
            })->implode(', ') !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<nav class="nav">
    {{ $items->pages->links() }}
</nav>
@endsection
