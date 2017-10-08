<?php

namespace App\Models;

use App\Support\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'invite_code',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function loginToken($token = null): LoginToken
    {
        return new LoginToken($this, $token);
    }

    public function invite()
    {
        return $this->belongsTo(Invite::class, 'invite_code', 'code');
    }

    public function mainDataset()
    {
        return $this->belongsTo(Dataset::class, 'main_dataset_id');
    }

    public function datasets()
    {
        return $this->hasMany(Dataset::class, 'creator_id');
    }
}
