<?php

namespace App\GraphQL\Query;

use App\GraphQL\Support\Type;
use App\Models\Item;
use Folklore\GraphQL\Support\Query;
use GraphQL;

class RandomQuery extends Query
{
    protected $attributes = [
        'name' => 'random'
    ];

    public function type()
    {
        return Type::nonNull(Type::listOf(GraphQL::type('Item')));
    }

    public function args()
    {
        return [
            'limit' => ['name' => 'limit', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        if (empty($args['limit']) || $args['limit'] < 1) {
            $args['limit'] = 1;
        }
        if ($args['limit'] > 100) {
            $args['limit'] = 100;
        }
        return Item::inRandomOrder()->limit($args['limit'])->get();
    }
}
