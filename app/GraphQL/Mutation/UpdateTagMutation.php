<?php

namespace App\GraphQL\Mutation;

use App\GraphQL\Support\Type;
use App\Models\Tag;
use GraphQL;
use Folklore\GraphQL\Support\Mutation;

class UpdateTagMutation extends Mutation
{
    protected $attributes = [
        'name' => 'update_tag',
        'description' => 'Update a Tag and return it. Non-conforming arguments will be silently ignored.'
    ];

    public function type()
    {
        return GraphQL::type('Tag');
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
                'description' => 'Optional. A non-empty string (max 200 chars) for the name of the Tag.',
                'type' => Type::string()
            ],
            'description' => [
                'name' => 'description',
                'description' => 'Optional. Arbitrary-length description of the Tag. Set to the empty-string to delete.',
                'type' => Type::string()
            ],
            'parent_id' => [
                'name' => 'parent_id',
                'description' => 'Optional. The ID of an existing Tag to set as parent. Set to 0 to remove the association.',
                'type' => Type::id()
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $tag = Tag::find($args['id']);
        if (!$tag) {
            return null;
        }

        if (!empty($args['name']) && strlen($args['name']) <= 200) {
            $tag->name = $args['name'];
        }

        if (isset($args['description'])) {
            $tag->description = $args['description'] ?: null;
        }

        if (!empty($args['parent_id'])) {
            $pid = $args['parent_id'];
            if ($pid < 1) {
                $tag->parent()->dissociate();
            } else {
                $parent = Tag::find($pid);
                if ($parent) {
                    $tag->parent()->associate($parent);
                }
            }
        }

        $tag->save();
        return $tag;
    }
}
