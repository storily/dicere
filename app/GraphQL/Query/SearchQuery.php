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
        return Type::nonNull(Type::listOf(GraphQL::type('SearchResult')));
    }

    public function args()
    {
        return [
            'query' => ['name' => 'query', 'type' => Type::nonNull(Type::string())],
            'limit' => ['name' => 'limit', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {

        if (empty($args['limit']) || $args['limit'] < 1)
            return Search::search($args['query']);
        else {
            if ($args['limit'] > 100) $args['limit'] = 100;
            return Search::search($args['query'], $args['limit']);
        }
    }
}
