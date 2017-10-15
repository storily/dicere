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

    public function meta(string $field = null)
    {
        if ($field === null) {
            return $this->metadata ?? [];
        }

        if (!$this->metadata) {
            return null;
        }

        if (!isset($this->metadata[$field])) {
            return null;
        }

        return $this->metadata[$field];
    }

    public function setMeta(string $field, $value): self
    {
        $meta = $this->meta();
        $meta[$field] = $value;
        $this->metadata = $meta;
        return $this;
    }

    public function unsetMeta(string $field): self
    {
        $meta = $this->meta();
        unset($meta[$field]);
        $this->metadata = $meta;
        return $this;
    }
}
