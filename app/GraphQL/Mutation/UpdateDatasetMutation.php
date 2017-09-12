<?php

namespace App\GraphQL\Mutation;

use App\GraphQL\Support\Type;
use App\Models\Dataset;
use GraphQL;
use Folklore\GraphQL\Support\Mutation;

class UpdateDatasetMutation extends Mutation
{
    protected $attributes = [
        'name' => 'update_dataset',
        'description' => 'Update a Dataset and return it. Non-conforming arguments will be silently ignored.'
    ];

    public function type()
    {
        return GraphQL::type('Dataset');
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'description' => 'Mandatory. The ID of the Tag to update.',
                'type' => Type::nonNull(Type::id())
            ],
            'name' => [
                'name' => 'name',
                'description' => 'Optional. A non-empty string (max 200 chars) for the name of the Dataset.',
                'type' => Type::string()
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $set = Dataset::find($args['id']);
        if (!$set) {
            return null;
        }

        if (!empty($args['name']) && strlen($args['name']) <= 200) {
            $set->name = $args['name'];
        }

        $set->save();
        return $set;
    }
}
