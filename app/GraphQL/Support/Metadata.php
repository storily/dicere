<?php

namespace App\GraphQL\Support;

use App\GraphQL\Support\Type;
use GraphQL;

trait Metadata
{
    private function metadataField()
    {
        return [
            'type' => Type::nonNull(Type::listOf(GraphQL::type('Metadata'))),
            'description' => 'An array of metadata key-value pairs',
            'args' => [
                'key' => [
                    'type' => Type::string(),
                    'description' => 'Search metadata by key'
                ]
            ]
        ];
    }

    public function resolveMetadataField($item, $args)
    {
        $meta = $item->metadata ?? null;
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
}
