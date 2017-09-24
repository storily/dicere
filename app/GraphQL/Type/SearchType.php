<?php

namespace App\GraphQL\Type;

use App\GraphQL\Support\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class SearchType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Search',
        'description' => 'A set of results in response of a search'
    ];

    public function fields()
    {
        return [
            'results' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('SearchResult'))),
                'description' => 'The list of results'
            ],
            'datasets_considered' => [
                'type' => Type::nonNull(Type::listOf(GraphQL::type('Dataset'))),
                'description' => 'The datasets that were considered for this search'
            ],
        ];
    }
}
