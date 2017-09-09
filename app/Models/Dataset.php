<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
