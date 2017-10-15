<?php

namespace App\Models;

use App\Support\AuthModel;

class User extends AuthModel
{
    protected $fillable = [
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

    public function dataset()
    {
        $ds = $this->mainDataset;
        if (!$ds) {
            $ds = Dataset::create([
                'name' => "{$this->email}’s dataset",
                'description' => "{$this->email}’s personal dataset, where items go by default.",
                'creator_id' => $this->id,
                'metadata' => [
                    'author' => $this->email
                ]
            ]);

            $this->mainDataset()->associate($ds);
            $this->save();
        }

        return $ds;
    }

    public function datasets()
    {
        return $this->hasMany(Dataset::class, 'creator_id');
    }
}
