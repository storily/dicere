<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    protected $fillable = [
        'text',
        'created',
        'updated',
        'metadata',
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
