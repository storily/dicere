<?php

namespace App\GraphQL\Mutation;

use App\GraphQL\Support\Type;
use App\Models\Tag;
use GraphQL;
use Folklore\GraphQL\Support\Mutation;

class CreateTagMutation extends Mutation
{
    protected $attributes = [
        'name' => 'create_tag',
        'description' => 'Create a Tag and return it.'
    ];

    public function type()
    {
        return GraphQL::type('Tag');
    }

    public function args()
    {
        return [
            'name' => [
                'name' => 'name',
                'description' => 'Mandatory. A non-empty string (max 200 chars) for the name of the Tag.',
                'type' => Type::nonNull(Type::string())
            ],
            'description' => [
                'name' => 'description',
                'description' => 'Optional. Arbitrary-length description of the Tag.',
                'type' => Type::string()
            ],
            'parent_id' => [
                'name' => 'parent_id',
                'description' => 'Optional. The ID of an existing Tag to set as parent.',
                'type' => Type::id()
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = new Tag;

        if (strlen($args['name']) > 200) {
            throw new InvalidArgumentException('name cannot be longer than 200 characters.');
        }

        $user->name = $args['name'];

        if (!empty($args['description'])) {
            $user->description = $args['description'];
        }

        if (!empty($args['parent_id'])) {
            $pid = $args['parent_id'];
            if ($pid < 1) {
                throw new InvalidArgumentException('parent_id is not in range.');
            } else {
                $parent = Tag::find($pid);
                if ($parent) {
                    $user->parent()->associate($parent);
                } else {
                    throw new InvalidArgumentException('parent_id does not refer to an existing tag.');
                }
            }
        }

        $user->save();
        return $user;
    }
}
