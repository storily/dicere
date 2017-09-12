<?php

namespace App\GraphQL\Mutation;

use App\GraphQL\Support\Type;
use App\Models\Dataset;
use GraphQL;
use Folklore\GraphQL\Support\Mutation;

class DeleteDatasetMutation extends Mutation
{
    protected $attributes = [
        'name' => 'delete_dataset',
        'description' => 'Delete a Dataset. Return the ID of the deleted Dataset if it has been deleted.'
    ];

    public function type()
    {
        return Type::id();
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'description' => 'The ID of the Dataset to delete.',
                'type' => Type::nonNull(Type::id())
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $set = Dataset::find($args['id']);
        if (!$set) {
            return null;
        }

        $set->delete();
        return $set->id;
    }
}
