<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Tag;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('items.index', [
            'items' => (object) [
                'count' => Item::count(),
                'pages' => Item::orderBy('created', 'desc')->simplePaginate(25)
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'text' => 'required|string|min:5|unique:items'
        ]);

        $item = Item::create([
            'text' => $request->input('text'),
        ]);

        $item->dataset()->associate(\Auth::user()->dataset());
        $item->save();

        if ($request->input('tags')) {
            $tags = preg_split('/\s+/', strtolower(trim($request->input('tags'))));
            foreach ($tags as $name) {
                $tag = Tag::where('name', $name)->first();
                if (!$tag) {
                    $tag = Tag::create(['name' => $name]);
                }

                $item->tags()->attach($tag->id);
            }
        }

        if ($request->input('return_url')) {
            if (!$request->input('ignore_return')) {
                return redirect($request->input('return_url'));
            }
        }

        return redirect()->route('items.show', $item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('items.show', [
            'item' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('items.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if ($request->input('text')) {
            $item->text = $request->input('text');
        }

        if ($request->input('remove_tag')) {
            $id = trim($request->input('remove_tag'));
            $item->tags()->detach($id);
        }

        if ($request->input('new_tag')) {
            $tags = preg_split('/\s+/', strtolower(trim($request->input('new_tag'))));
            foreach ($tags as $name) {
                $tag = Tag::where('name', $name)->first();
                if (!$tag) {
                    $tag = Tag::create(['name' => $name]);
                }

                $item->tags()->attach($tag->id);
            }
        }

        if ($request->input('remove_metadata')) {
            $key = trim($request->input('remove_metadata'));
            $item->unsetMeta($key);
        }

        if ($request->input('new_metadata_key') && $request->input('new_metadata_value')) {
            $key = trim($request->input('new_metadata_key'));
            $value = trim($request->input('new_metadata_value'));

            $item->setMeta($key, $value);
        }

        $item->save();
        return redirect()->route('items.show', $item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index');
    }
}
