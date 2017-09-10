<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Models\Dataset;

class DatasetType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Dataset',
        'description' => 'A Dataset is a collection of Items that form a logical or historical group. A Dataset may have all been imported at the same time, or come from the same source, etc.'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the dataset'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the dataset'
            ],
            'metadata' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Metadata'))),
                'description' => 'An array of metadata key-value pairs',
                'args' => [
                    'key' => [
                        'type' => Type::string(),
                        'description' => 'Search metadata by key'
                    ]
                ]
            ],
            'items' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Item'))),
                'description' => 'Items that belong to this Dataset'
            ],
        ];
    }

    public function resolveMetadataField(Dataset $set, $args)
    {
        $meta = $set->metadata ?? null;
        if (!is_array($meta)) {
            return [];
        }

        if (!empty($args['key'])) {
            if (isset($meta[$args['key']])) {
                return [['key' => $args['key'], 'value' => $meta[$args['key']]]];
            } else {
                return [];
            }
        }

        $data = [];
        foreach ($meta as $key => $value) {
            $data[] = ['key' => $key, 'value' => $value];
        }

        return $data;
    }

    public function resolveItemsField(Dataset $set) {
        return $set->items()->get();
    }
}
