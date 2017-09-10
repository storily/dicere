<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use App\Models\Tag;

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
        ];
    }

    public function resolveItemsField(Tag $tag, $args)
    {
        return $tag->items()->get();
    }
}
