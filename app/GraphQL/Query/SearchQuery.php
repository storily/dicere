<?php

namespace App\GraphQL\Query;

use App\GraphQL\Support\Type;
use App\Models\Search;
use Folklore\GraphQL\Support\Query;
use GraphQL;

class SearchQuery extends Query
{
    protected $attributes = [
        'name' => 'search'
    ];

    public function type()
    {
        return Type::nonNull(Type::listOf(GraphQL::type('Item')));
        // return Type::nonNull(GraphQL::type('Search'));
    }

    public function args()
    {
        return [
            'query' => ['name' => 'query', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args)
    {
        return (new Search($args['query']))->perform();
    }
}
