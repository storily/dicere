<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
