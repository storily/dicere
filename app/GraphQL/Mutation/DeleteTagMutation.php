<?php

namespace App\GraphQL\Mutation;

use App\GraphQL\Support\Type;
use App\Models\Tag;
use GraphQL;
use Folklore\GraphQL\Support\Mutation;

class DeleteTagMutation extends Mutation
{
    protected $attributes = [
        'name' => 'delete_tag',
        'description' => 'Delete a Tag. Return the ID of the deleted Tag if it has been deleted.'
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
                'description' => 'The ID of the Tag to delete.',
                'type' => Type::nonNull(Type::id())
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = Tag::find($args['id']);
        if (!$user) {
            return null;
        }

        $user->delete();
        return $user->id;
    }
}
