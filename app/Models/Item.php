<?php

namespace App\Models;

use App\Support\Model;

class Item extends Model
{
    protected $fillable = [
        'text',
        'created',
        'updated',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function author()
    {
        return $this->metadata['author']
            ?? $this->dataset->metadata['author']
            ?? null;
    }

    public function license(): string
    {
        return $this->metadata['license']
            ?? $this->dataset->metadata['license']
            ?? 'CC-BY-4.0';
    }

    public function indexObject()
    {
        return [
            'objectID' => $this->id,
            'text' => $this->text,
            'metadata' => $this->metadata + [
                'author' => $this->author(),
                'license' => $this->license(),
            ],
            'dataset' => $this->dataset->name,
            'tags' => $this->tags->flatMap(function ($tag) {
                return collect($tag->withParents())->map(function ($tag) {
                    return $tag->name;
                });
            })->all(),
        ];
    }
}
