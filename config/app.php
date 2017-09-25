<?php

return [
    'legare' => [
        'host' => env('LEGARE_HOST', 'https://legare.herokuapp.com'),
    ],

    'algolia' => [
        'app_id' => env('ALGOLIA_APP'),
        'api_key' => env('ALGOLIA_KEY'),
        'index' => env('ALGOLIA_IDX', 'prod_cogitare'),
    ],

    'reindex' => [
        'interval' => 10,
    ]
];
