<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Models\Item;

class ItemType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Item',
        'description' => 'An item'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the item'
            ],
            'text' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The full text of the item'
            ],
            'metadata' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Metadata'))),
                'description' => 'An array of metadata key-value pairs'
            ],
        ];
    }

    public function resolveMetadataField(Item $item)
    {
        $meta = $item->metadata ?? null;
        if (!is_array($meta)) {
            return [];
        }

        $data = [];
        foreach ($meta as $key => $value) {
            $data[] = ['key' => $key, 'value' => $value];
        }

        return $data;
    }
}
