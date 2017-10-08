<?php

namespace App\GraphQL\Type;

use App\GraphQL\Support\Type;
use App\Models\Tag;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class TagType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Tag',
        'description' => 'A tag'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the tag'
            ],
            'created' => [
                'type' => Type::nonNull(Type::timestamp()),
                'description' => "When the tag was created",
            ],
            'updated' => [
                'type' => Type::nonNull(Type::timestamp()),
                'description' => "When the tag was last updated",
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the tag'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'A description of the tag'
            ],
            'items' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Item'))),
                'description' => 'The Items that have this Tag'
            ],
            'parent' => [
                'type' => GraphQL::type('Tag'),
                'description' => 'This tag’s parent'
            ],
            'children' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Tag'))),
                'description' => 'This tag’s children'
            ],
        ];
    }

    public function resolveItemsField(Tag $tag, $args)
    {
        return $tag->items()->get();
    }
}
