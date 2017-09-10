<?php

namespace App\GraphQL\Type;

use App\GraphQL\Support\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class MetadataType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Metadata',
        'description' => 'A single key-value pair of metadata'
    ];

    public function fields()
    {
        return [
            'key' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The metadata key'
            ],
            'value' => [
                'type' => Type::string(),
                'description' => 'If the value is not empty / null, then a stringified version of the value. Otherwise, null.'
            ],
            'boolean' => [
                'type' => Type::boolean(),
                'description' => 'If the value is a boolean, then provide it here. Otherwise, null.'
            ],
            'integer' => [
                'type' => Type::int(),
                'description' => 'If the value is an integer, then provide it here. Otherwise, null.'
            ],
            'float' => [
                'type' => Type::float(),
                'description' => 'If the value is a float, then provide it here. Otherwise, null.'
            ],
            'string' => [
                'type' => Type::string(),
                'description' => 'If the value is a string, then provide it here. Otherwise, null.'
            ],
            'json' => [
                'type' => Type::string(),
                'description' => 'Represents the value as a JSON value, regardless of type.'
            ],
        ];
    }

    public function resolveValueField($data)
    {
        if (empty($data['value'])) {
            return null;
        } elseif (!is_string($data['value'])) {
            return json_encode($data['value']);
        } else {
            return $data['value'];
        }
    }

    public function resolveBooleanField($data)
    {
        if (is_bool($data['value'] ?? null)) {
            return $data['value'];
        }
    }

    public function resolveIntegerField($data)
    {
        if (is_int($data['value'] ?? null)) {
            return $data['value'];
        }
    }

    public function resolveFloatField($data)
    {
        if (is_float($data['value'] ?? null)) {
            return $data['value'];
        }
    }

    public function resolveStringField($data)
    {
        if (is_string($data['value'] ?? null)) {
            return $data['value'];
        }
    }

    public function resolveJsonField($data)
    {
        return json_encode($data['value']);
    }
}
