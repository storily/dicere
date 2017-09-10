<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Models\Tag;

class TagsQuery extends Query
{
    protected $attributes = [
        'name' => 'tags'
    ];

    public function type()
    {
        return Type::nonNull(Type::listOf(GraphQL::type('Tag')));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::id()],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return Tag::where('id', $args['id'])->get();
        } else {
            return Tag::all();
        }
    }
}
