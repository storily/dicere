<?php

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Models\Dataset;

class DatasetsQuery extends Query
{
    protected $attributes = [
        'name' => 'datasets'
    ];

    public function type()
    {
        return Type::nonNull(Type::listOf(GraphQL::type('Dataset')));
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
            return Dataset::where('id', $args['id'])->get();
        } else {
            return Dataset::all();
        }
    }
}
