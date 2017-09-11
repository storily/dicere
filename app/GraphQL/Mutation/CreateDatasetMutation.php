<?php

namespace App\GraphQL\Mutation;

use App\GraphQL\Support\Type;
use App\Models\Dataset;
use GraphQL;
use Folklore\GraphQL\Support\Mutation;

class CreateDatasetMutation extends Mutation
{
    protected $attributes = [
        'name' => 'create_dataset',
        'description' => 'Create a Dataset and return it.'
    ];

    public function type()
    {
        return GraphQL::type('Dataset');
    }

    public function args()
    {
        return [
            'name' => [
                'name' => 'name',
                'description' => 'Mandatory. A non-empty string (max 200 chars) for the name of the Dataset.',
                'type' => Type::nonNull(Type::string())
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $set = new Dataset;

        if (strlen($args['name']) > 200) {
            throw new InvalidArgumentException('name cannot be longer than 200 characters.');
        }

        $set->name = $args['name'];

        $set->save();
        return $set;
    }
}
