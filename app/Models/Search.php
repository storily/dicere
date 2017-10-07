<?php

namespace App\Models;

use AlgoliaSearch\Client;

class Search
{
    public static function search(string $query, int $limit = 20)
    {
        $query = static::normalise($query);
        $results = static::algolia()->search($query, [
            'hitsPerPage' => $limit,
            'attributesToRetrieve' => [],
            'getRankingInfo' => true,
            'advancedSyntax' => true,
        ]);

        if (empty($results['hits'])) {
            return [];
        }

        return array_map(function ($hit) {
            return [
                'item' => Item::find($hit['objectID']),
                'score' => $hit['_rankingInfo']['userScore'],
            ];
        }, $results['hits']);
    }

    public static function normalise(string $query)
    {
        return preg_replace(
            '/\s+/',
            ' ',
            str_replace(
                WS,
                ' ',
                str_replace(
                    SINGLE_QUOTE,
                    '\'',
                    str_replace(
                        DOUBLE_QUOTE,
                        '"',
                        str_replace(DASH, '-', $query)
                    )
                )
            )
        );
    }

    public static function reindex(callable $fn = null): array
    {
        $n = 0;
        $d = 0;

        Item::with(['dataset', 'tags', 'tags.parent'])->chunk(100, function ($items) use ($fn, &$n) {
            $n += count($items);
            if ($fn) {
                $fn(count($items, $n));
            }
            static::algolia()->addObjects($items->map(function ($item) {
                return $item->indexObject();
            })->all());
        });

        Item::onlyTrashed()->with(['dataset', 'tags', 'tags.parent'])->chunk(100, function ($items) use ($fn, &$d) {
            $d += count($items);
            if ($fn) {
                $fn(count($items, $d));
            }
            static::algolia()->deleteObjects($items->map(function ($item) {
                return $item->id;
            })->all());
        });

        return [$n, $d];
    }

    private static $algolia = null;
    private static $index = null;
    public static function algolia()
    {
        if (static::$index !== null) {
            return static::$index;
        }

        static::$algolia = new Client(
            config('algolia.app_id'),
            config('algolia.api_key')
        );

        return (static::$index = static::$algolia->initIndex(
            config('algolia.index')
        ));
    }
}

const WS = [
  "\u{09}",  // TAB
  "\u{0A}",  // LF
  "\u{0D}",  // CR
  "\u{20}",  // Space
  "\u{85}",  // NEL
  "\u{A0}",  // NBSP

  "\u{2000}",  // EN QUAD
  "\u{2001}",  // EM QUAD
  "\u{2002}",  // EN SPACE
  "\u{2003}",  // EM SPACE
  "\u{2004}",  // ⅓ EM SPACE
  "\u{2005}",  // ¼ EM SPACE
  "\u{2006}",  // ⅙ EM SPACE
  "\u{2007}",  // FIGURE SPACE
  "\u{2008}",  // PUNCTUATION SPACE
  "\u{2009}",  // THIN SPACE
  "\u{200A}",  // HAIR SPACE

  "\u{202F}",  // NARROW NBSP
  "\u{205F}",  // MATH SPACE
  "\u{3000}",  // IDEOGRAPHIC SPACE
];

const DOUBLE_QUOTE = [
  "\u{0022}",  // STRAIGHT DOUBLE
  "\u{00AB}",  // LEFT GUILLEMET
  "\u{00BB}",  // RIGHT GUILLEMET
  "\u{201C}",  // LEFT DOUBLE CURVY
  "\u{201D}",  // RIGHT DOUBLE CURVY
  "\u{2033}",  // DOUBLE PRIME
];

const SINGLE_QUOTE = [
  "\u{0027}",  // STRAIGHT SINGLE
  "\u{2039}",  // LEFT CHEVRON
  "\u{203A}",  // RIGHT CHEVRON
  "\u{2018}",  // LEFT SINGLE CURVY
  "\u{2032}",  // PRIME
];

const DASH = [
  "--"      ,  // DOUBLE HYPHEN
  "\u{202D}",  // HYPHEN MINUS
  "\u{2012}",  // FIGURE DASH
  "\u{2013}",  // EN DASH
  "\u{2014}",  // EM DASH
  "\u{2015}",  // HORIZONTAL BAR
  "\u{2053}",  // SWUNG DASH
  "\u{2E3A}",  // 2 EM DASH
  "\u{2E3B}",  // 3 EM DASH
  "\u{301C}",  // JAPANESE WAVE DASH
  "\u{30FC}",  // CHOONPU
  "\u{FF5E}",  // CHINESE WAVE DASH
];
