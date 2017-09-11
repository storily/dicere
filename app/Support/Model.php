<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use SoftDeletes;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    const DELETED_AT = 'deleted';
    protected $dateFormat = 'Y-m-d H:i:s.uP';
    protected $dates = ['deleted'];
}
