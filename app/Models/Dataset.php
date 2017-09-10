<?php

namespace App\Models;

use App\Support\Model;

class Dataset extends Model
{
    protected $fillable = [
        'name',
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
