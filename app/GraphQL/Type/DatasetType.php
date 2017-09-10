<?php

namespace App\GraphQL\Type;

use App\GraphQL\Support\Metadata;
use App\GraphQL\Support\Type;
use App\Models\Dataset;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class DatasetType extends GraphQLType
{
    use Metadata;

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
            'created' => [
                'type' => Type::nonNull(Type::timestamp()),
                'description' => "When the dataset was created",
            ],
            'updated' => [
                'type' => Type::nonNull(Type::timestamp()),
                'description' => "When the dataset was last updated",
            ],
            'imported' => [
                'type' => Type::nonNull(Type::timestamp()),
                'description' => "When the dataset was imported. This might be different from the created time.",
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the dataset'
            ],
            'metadata' => $this->metadataField(),
            'items' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Item'))),
                'description' => 'Items that belong to this Dataset'
            ],
        ];
    }

    public function resolveItemsField(Dataset $set)
    {
        return $set->items()->get();
    }
}
