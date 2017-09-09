<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Models\Item;

class ItemsQuery extends Query
{
    protected $attributes = [
        'name' => 'items'
    ];

    public function type()
    {
        return Type::nonNull(Type::listOf(GraphQL::type('Item')));
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
            return Item::where('id', $args['id'])->get();
        } else {
            return Item::all();
        }
    }
}
