<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'created',
        'updated',
    ];

    public function item()
    {
        return $this->HasMany(Item::class);
    }
}
