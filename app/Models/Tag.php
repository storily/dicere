<?php

namespace App\Models;

use App\Support\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created',
        'updated',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function parent()
    {
        return $this->belongsTo(Tag::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Tag::class, 'parent_id');
    }
}
