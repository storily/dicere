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

    public function items()
    {
        return $this->HasMany(Item::class);
    }
}
