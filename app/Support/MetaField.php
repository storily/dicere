<?php

namespace App\Support;

trait MetaField
{
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
