<?php

namespace App\Support;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthModel extends Authenticatable
{
    use MetaField;
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    const DELETED_AT = 'deleted';
    protected $dateFormat = 'Y-m-d H:i:s.uP';
    protected $dates = ['deleted'];
}
