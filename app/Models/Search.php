<?php

namespace App\Models;
use AlgoliaSearch\Client;
use Unirest\Request;

class Search
{
    public static function search(string $query, int $limit = 20)
    {
        $query = static::normalise($query);
        $results = static::algolia()->search($query, [
            'hitsPerPage' => $limit,
            'attributesToRetrieve' => [],
            'getRankingInfo' => true
        ]);

        if (empty($results['hits'])) return [];

        return array_map(function ($hit) {
            return [
                'item' => Item::find($hit['objectID']),
                'score' => $hit['_rankingInfo']['userScore'],
            ];
        }, $results['hits']);
    }

    public static function normalise(string $query)
    {
        Request::jsonOpts(true);
        $resp = Request::post(config('app.legare.host'), null, $query)->body;
        if ($resp['error']) {
            throw new \Exception($resp['reason'] . "\n\n" . implode("\n", $resp['details']));
        }

        return $resp['normalised'];
    }

    public static function reindex()
    {
        Item::with(['dataset', 'tags', 'tags.parent'])->chunk(100, function ($items) {
            static::algolia()->addObjects($items->map(function ($item) {
                return $item->indexObject();
            })->all());
        });

        Item::onlyTrashed()->with(['dataset', 'tags', 'tags.parent'])->chunk(100, function ($items) {
            static::algolia()->deleteObjects($items->map(function ($item) {
                return $item->id;
            })->all());
        });
    }

    private static $algolia = null;
    private static $index = null;
    public static function algolia()
    {
        if (static::$index !== null) return static::$index;

        static::$algolia = new Client(
            config('app.algolia.app_id'),
            config('app.algolia.api_key')
        );

        return (static::$index = static::$algolia->initIndex(
            config('app.algolia.index')
        ));
    }
}
