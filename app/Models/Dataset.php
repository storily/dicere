<?php

namespace App\Models;

use App\Support\Model;

class Dataset extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created',
        'updated',
        'imported',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function items()
    {
        return $this->HasMany(Item::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
