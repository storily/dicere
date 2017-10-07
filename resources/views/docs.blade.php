@extends('layouts.public')

@section('content')
<h1 class="title m-b-md">Docs</h1>

<div class="links">
    <a href="#data">Data</a>
    <a href="#bots">For bots</a>
    <a href="#auth">Access</a>
</div>

<p>
    <strong class="cogitare">Cogitare</strong> is a repository for prompts,
    writing seeds, plots, twists, and ideas… more generally, it's a repository
    for curated bits of text accompanied by tags, from various original sources.
</p>

<p>
    <strong>Dicere</strong> is the set of systems that make it all work. It has
    three parts: the <em>public API</em> exposes the data to anything that may
    want to consume it, be it websites, bots, or other systems; the <em>admin
    interface</em> allows select people to add and manage the data (by invite
    only, at this point); the <em>search interface</em>, which is exposed in the
    public API, is powered by <a href="https://algolia.com">Algolia</a> and lets
    anyone perform powerful searches over the entire collection.
</p>

<h2 id="data"><a href="#data">Data</a></h2>
<div class="links">
    <a href="#data-items">Items</a>
    <a href="#data-tags">Tags</a>
    <a href="#data-datasets">Datasets</a>
    <a href="#data-metadata">Metadata</a>
</div>

<p>
    <strong><a href="#data-items">Items</a></strong> contain the actual data,
    the prompts, seeds, etc. They have zero or more <strong>tags</strong>, they
    belong to a <strong>dataset</strong>, and may have arbitrary metadata
    attached to them.
</p>

<p>
    <strong><a href="#data-tags">Tags</a></strong> are hierarchised: they may
    have a <strong>parent tag</strong> that is a “superset” category. Tags are
    the main classification mechanism. Some tags are assigned special meaning
    and may affect default behaviour.
</p>

<p>
    <strong><a href="#data-datasets">Datasets</a></strong> are collections of
    items that share a common source or author or theme. While datasets
    <em>can</em> be explored on their own, the main purpose of datasets is for
    attribution. Additionally, datasets can be used for blocks: all items
    belonging to the dataset will disappear from the public view if the
    corresponding dataset is disabled.
</p>

<h3 id="data-items"><a href="#data-items">Items</a></h3>
<h3 id="data-tags"><a href="#data-tags">Tags</a></h3>
<h3 id="data-datasets"><a href="#data-datasets">Datasets</a></h3>
<h3 id="data-metadata"><a href="#data-metadata">Metadata</a></h3>

<h2 id="bots"><a href="#bots">For bots</a></h2>
<h2 id="auth"><a href="#auth">Access</a></h2>
@endsection
