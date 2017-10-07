<?php

return [
    'app_id' => env('ALGOLIA_APP'),
    'api_key' => env('ALGOLIA_KEY'),
    'index' => env('ALGOLIA_IDX', 'prod_cogitare'),

    'reindex' => [
        'interval' => env('REINDEX', 10),
    ]
];
