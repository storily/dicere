<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
