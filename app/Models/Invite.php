<?php

namespace App\Models;

use App\Support\Model;

class Invite extends Model
{
    protected $fillable = [
        'code',
    ];

    public function inviter()
    {
        return $this->belongsTo(User::model, 'inviter_id');
    }
}
