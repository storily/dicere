<?php

namespace App\Models;
use Unirest\Request;

class Search
{
    private $ast = null;
    private $normal = null;
    private $query = null;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    private function parse()
    {
        if ($this->ast) return $this;

        Request::jsonOpts(true);
        $resp = Request::post(config('app.legare.host'), null, $this->query)->body;
        if ($resp['error']) {
            throw new \Exception($resp['reason'] . "\n\n" . implode("\n", $resp['details']));
        }

        $this->normal = $resp['normalised'];
        $this->ast = $resp['parsed'];
        return $this;
    }

    private static function where ($expression, $level = 0, $mult = 1)
    {
        $where = Item::select('items.*')->distinct()
            ->join('item_tag', 'items.id', '=', 'item_tag.item_id')
            ->join('tags', 'tags.id', '=', 'item_tag.tag_id');

        $args = [];
        $logic = 'where';
        $import = 10;
        foreach ($expression as $i => $term) {
            $import -= 1; if ($import < 0) $import = 1;
            $type = array_keys($term)[0];
            $value = array_values($term)[0];
            $multiplier = $import * $mult / (pow(10, $level));

            switch ($type) {
                case 'Word':
                    $where = $where->$logic('tags.name', 'LIKE', "%$value%");
                    break;
                case 'Id':
                    $where = $where->$logic('items.id', '=', $value);
                    break;
                case 'Pair': // TODO
                    $where = $where->$logic('tags.name', '=', $value);
                    break;
                case 'Quote':
                    $where = $where->$logic('items.text', 'LIKE', "%$value%");
                    break;
                // case 'Group':
                //     $
            }

            switch ($type) {
                case 'LogicOr':
                    $import += 1;
                    $logic = 'orWhere';
                    continue 2;
                case 'LogicNot':
                    $import += 1;
                    $not = 'NOT ';
                    continue 2;
                default:
                    $logic = 'where';
                    $not = '';
            }
        }

        return $where->get();
    }

    public function perform()
    {
        return static::where($this->parse()->ast);
    }
}
