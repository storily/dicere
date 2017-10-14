@extends('layouts.base')

@section('content')
<h1 class="title m-b-md">Docs</h1>

<nav class="nav">
    <a href="#data">Data</a>
    <a href="#bots">For bots</a>
    <a href="#auth">Access</a>
    <a href="#auth">License</a>
</nav>

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
<nav class="nav justify-content-center">
    <a href="#data-items">Items</a>
    <a href="#data-tags">Tags</a>
    <a href="#data-datasets">Datasets</a>
    <a href="#data-metadata">Metadata</a>
</nav>

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

<p>
    All data has soft-deletion enabled: when data is “deleted” it is removed
    from public view but remains in the store. That enables worry-free and
    reversible deletion.
</p>

<p>
    In the documentation, some implementation concerns like soft-deletion and
    additional relationships and data like <em>users</em> or <em>histories</em>
    are mentioned, but not further described. These are included for context,
    but are only used for internal book-keeping and administration, and are not
    available for public access.
</p>

<h3 id="data-items"><a href="#data-items">Items</a></h3>

<p>
    At their core, items are a unique blob of content. To that is attached some
    supporting metadata, both structured and arbitrary. Content at this point is
    a string of Markdown text. In the future, images may be added as first-class
    content; for now they can be embedded in the Markdown.
</p>

<p>
    Conceptually, each item should be a short bit of text (that could fit in a
    tweet or two — no more than fifty words), but that is only a guideline. They
    should be standalone and provide a seed of inspiration for a writer, poet,
    artist, or whomever to spur the exercise of their creativity onwards.
</p>

<p>
    Items have the following fields and relations:
</p>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>id</th>
            <td>integer</td>
        </tr>
        <tr>
            <th>text</th>
            <td>string</td>
        </tr>
        <tr>
            <th>created</th>
            <td>timestamp</td>
        </tr>
        <tr>
            <th>updated</th>
            <td>timestamp</td>
        </tr>
        <tr>
            <th>metadata</th>
            <td>array of key-value pairs</td>
        </tr>
        <tr>
            <th>dataset</th>
            <td><a href="#data-datasets">Dataset</a></td>
        </tr>
        <tr>
            <th>tags</th>
            <td>array of <a href="#data-tags">Tags</a></td>
        </tr>
    </tbody>
</table>

<h3 id="data-tags"><a href="#data-tags">Tags</a></h3>

<p>
    A tag is a short, case-insentive string of text that provides either:

    <ul>
        <li>unified classification of terms or concepts that appear in items, or</li>
        <li>additional contextual metadata on what the item is about, or</li>
        <li>content advisories and fandom categorisation.</li>
    </ul>
</p>

<p>
    Tags can contain any type of characters, but generally are of the
    <code>lowercase-with-hyphens</code> variety, or <code>name-with:value</code>.
    The second form is meant to represent related variants, e.g.
    <code>colour:blue</code>. Because search looks at parts of terms as well as
    the whole, searching for <code>colour</code> or <code>blue</code> would both
    match this tag.
</p>

<p>
    Tags also have an optional freeform description that can contain additional
    details and notes on meaning. Tag descriptions are not considered when
    indexing items for search.
</p>

<p>
    Tags can have an optional parent tag, which is automatically included
    (recursively) when indexing items for search, so if <code>jedi</code> has a
    parent of <code>star-wars</code>, and an item is tagged with
    <code>jedi</code> (but not <code>star-wars</code>), searching for
    "star wars" would include the item.
</p>

<p>
    Tags have the following fields and relations:
</p>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>id</th>
            <td>integer</td>
        </tr>
        <tr>
            <th>name</th>
            <td>string</td>
        </tr>
        <tr>
            <th>description</th>
            <td>string</td>
        </tr>
        <tr>
            <th>created</th>
            <td>timestamp</td>
        </tr>
        <tr>
            <th>updated</th>
            <td>timestamp</td>
        </tr>
        <tr>
            <th>parent</th>
            <td><a href="#data-tags">Tag</a></td>
        </tr>
        <tr>
            <th>children</th>
            <td>array of <a href="#data-tags">Tags</a></td>
        </tr>
        <tr>
            <th>items</th>
            <td>array of <a href="#data-items">Items</a></td>
        </tr>
    </tbody>
</table>

<h3 id="data-datasets"><a href="#data-datasets">Datasets</a></h3>

<p>
    When items are added to <span class="cogitare">Cogitare</span>, there's
    three scenarios:

    <ul>
        <li>items are added a few at a time as they are thought of, or</li>
        <li>they are added over time to a related collection, or</li>
        <li>they are imported or added in bulk from a source.</li>
    </ul>
</p>

<p>
    In the first case, items go in an <em>user's dataset</em>, which is the
    default dataset for random submissions made by a user. In the second case,
    a separate dataset is added to over time; it represents the collection and
    may be contributed to by different users. In the third case, the dataset
    represents attribution and source for the entire bulk of items.
</p>

<p>
    Datasets are strongly linked to their items: if a dataset is marked as
    deleted, all items in the dataset are also marked such. If a dataset is
    restored, all items are also restored. However, items may also be
    individually deleted without affecting the whole dataset.
</p>

<p>
    Dataset names are included with items for indexing, so they can be used as
    filters or discovery when searching.
</p>

<p>
    Datasets have the following fields and relations:
</p>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>id</th>
            <td>integer</td>
        </tr>
        <tr>
            <th>name</th>
            <td>string</td>
        </tr>
        <tr>
            <th>description</th>
            <td>string</td>
        </tr>
        <tr>
            <th>created</th>
            <td>timestamp</td>
        </tr>
        <tr>
            <th>updated</th>
            <td>timestamp</td>
        </tr>
        <tr>
            <th>imported</th>
            <td>timestamp</td>
        </tr>
        <tr>
            <th>metadata</th>
            <td>array of key-value pairs</td>
        </tr>
        <tr>
            <th>items</th>
            <td>array of <a href="#data-items">Items</a></td>
        </tr>
    </tbody>
</table>

<h3 id="data-metadata"><a href="#data-metadata">Metadata</a></h3>

<p>
    Both <a href="#data-items">Items</a> and <a href="#data-datasets">Datasets</a>
    have a <strong>metadata</strong> field. Metadata is stored as key-value
    pairs: a string key and a value of any type. To expose this structure in
    GraphQL in a way that reduces burden on consumers and doesn't lose typing
    information, a special interface is presented.
</p>

<p>
    Two generic fields provide universal access to unknown-type values:

    <ul>
        <li>
            <strong>value</strong> exposes a <em>stringified</em> version of the
            value or <code>null</code> if the value is empty or null, and
        </li>
        <li>
            <strong>json</strong> exposes a JSON-encoded string of the value
            regardless of type.
        </li>
    </ul>
</p>

<p>
    Typed access is done through type-named fields that all operate on the same
    principle: if the field is of the type, the value is provided, otherwise
    <code>null</code> is returned:
</p>

<ul>
    <li><strong>boolean</strong></li>
    <li><strong>integer</strong></li>
    <li><strong>float</strong></li>
    <li><strong>string</strong></li>
</ul>

<h2 id="bots"><a href="#bots">For bots</a></h2>

<p>
    Bots may of course used the full interface and operate on the data as they
    see fit, but as a general guideline, the recommended access goes like this:

    <ol>
        <li>If the user provides no hints or search, go to 4.</li>
        <li>Perform a search with a large limit, but retrieving only
            <strong>text</strong>.</li>
        <li>Pick at random within that.</li>
        <li>If nothing is returned, query the <code>random</code> endpoint.</li>
    </ol>
</p>

<p>
    If the bot has a particular context or is for a particular event, you may
    want to filter the results further. In this case, you can return more fields
    from search results and perform filtering client-side. For search, you can
    try to include additional words in the query to filter server-side, too.
</p>

<p>
    Often, it is better to return <em>something</em> even if nothing matches.
    Consider what set of tags or datasets you should query for a “safe” random
    pick in your context.
</p>

<h2 id="auth"><a href="#auth">Access</a></h2>

<p>
    All data presented in the API is public and read-only.
</p>

<p>
    There is no authentication nor limits at the moment. This may change without
    notice if the service is heavily used and that reduces the quality of the
    access for everyone.
</p>

<p>
    If authentication is enabled, it would likely be a static token that would
    need to be provided as an <code>Authorization</code> header, obtainable on
    request and granted per application. A rate-limited anonymous access would
    still be provided. This information is provided as a non-binding indication
    only, so that you can design your solution with this eventuality in mind.
</p>

<h2 id="license"><a href="#license">License</a></h2>

<p>
    The data provided, while free to use, is <em>not</em> in the public domain.
    Each dataset may provide its own license, which will be provided in its
    metadata. By default, items are licensed for use under the
    <a href="https://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International</a>
    but remain the copyright of their authors.
</p>

<p>
    Whenever possible, licenses are expressed in
    <a href="https://spdx.org">SPDX format</a>. The special string "UNLICENSED"
    should be taken to mean that the item or dataset is not under any license.
</p>

<p>
    <strong>Dicere</strong> and <strong class="cogitare">Cogitare</strong> are
    themselves open-sourced under the
    <a href="https://spdx.org/licenses/Apache-2.0.txt">Apache 2.0</a>
    license. You can find them both on Github under the
    <a href="https://github.com/storily">Storily</a> organisation.
</p>
@endsection
