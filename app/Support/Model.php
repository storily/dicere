<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    protected $dateFormat = 'Y-m-d H:i:s.uP';
}
