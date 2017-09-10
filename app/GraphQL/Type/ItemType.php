<?php

namespace App\GraphQL\Type;

use App\Models\Item;
use App\GraphQL\Support\Metadata;
use App\GraphQL\Support\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class ItemType extends GraphQLType
{
    use Metadata;

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
            'created' => [
                'type' => Type::nonNull(Type::timestamp()),
                'description' => "When the item was created",
            ],
            'updated' => [
                'type' => Type::nonNull(Type::timestamp()),
                'description' => "When the item was last updated",
            ],
            'text' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The full text of the item'
            ],
            'metadata' => $this->metadataField(),
            'dataset' => [
                'type' => Type::nonNull(GraphQL::type('Dataset')),
                'description' => 'The Dataset this Item belongs to'
            ],
            'tags' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Tag'))),
                'description' => 'The Tags on this Item'
            ],
        ];
    }

    public function resolveTagsField(Item $item)
    {
        return $item->tags()->get();
    }
}
