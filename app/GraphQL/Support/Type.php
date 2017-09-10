<?php

namespace App\GraphQL\Support;

use BadMethodCallException;
use GraphQL\Type\Definition\Type as GraphQLType;

class Type extends GraphQLType
{
    private static $loaded = [];

    private static function loadType($name, $type)
    {
        if (isset(self::$loaded[$name])) {
            return self::$loaded[$name];
        }

        return (self::$loaded[$name] = new $type());
    }

    public static function timestamp()
    {
        return self::loadType('timestamp', \App\GraphQL\Type\TimestampType::class);
    }
}
