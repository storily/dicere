<?php

namespace App\GraphQL\Type;

use App\GraphQL\Support\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class SearchResultType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SearchResult',
        'description' => 'A single result in a search'
    ];

    public function fields()
    {
        return [
            'item' => [
                'type' => Type::nonNull(GraphQL::type('Item')),
                'description' => 'The item found by the search'
            ],
            'score' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'A positive float indicating the search score of this result. Higher is better.',
            ],
        ];
    }
}
