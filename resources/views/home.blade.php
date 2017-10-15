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

<p>
    There are currently {{ App\Models\Item::count() }} items,
    with {{ App\Models\Tag::count() }} tags,
    from {{ App\Models\Dataset::count() }} datasets.
</p>

<nav class="nav justify-content-center">
    <a href="/items">Items</a>
    <a href="/tags">Tags</a>
    <a href="/datasets">Datasets</a>
</nav>

<h3>Quickly add an item</h3>
<p>The item will be added to your <a>personal dataset</a>.</p>
<form action="/items/new" method="POST">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="new-item-text" class="control-label">Item / prompt / seed / plot</label>
        <textarea
            id="new-item-text"
            class="form-control item-input"
            name="text"
            required
            autofocus
            autocomplete="off"
        ></textarea>
    </div>

    <div class="form-group">
        <label for="new-item-tags" class="control-label">Tags (optional)</label>
        <input
            id="new-item-tags"
            type="text"
            class="form-control"
            name="tags"
            autocomplete="off"
        >

        <small class="form-text">
            Tags are space-separated. Try to keep to the
            <code>hyphenated-format</code>.
        </small>
    </div>

    <div class="form-group justify-content-between d-flex mt-4">
        <button type="submit" class="btn btn-primary">Add</button>
        <button type="submit" name="and-edit" class="btn btn-sm btn-outline-primary">Add and edit further</button>
    </div>
</form>

<h3>Index</h3>

<p>
    The search index was last updated {{ $stats->updated->diffForHumans() }}.
    It has {{ $stats->entries }} entries (out of 10,000 allowed), and last took
    {{ $stats->buildTime }} to build.
</p>

<small class="form-text mb-2">The index is updated every 10 minutes, but you can trigger one now:</small>
<button id="reindex" class="btn btn-primary">Reindex now</button>
@endsection
