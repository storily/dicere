<?php

namespace App\GraphQL\Type;

use DateTime;
use DateTimeImmutable;
use GraphQL\Error\Error;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use Exception;
use UnexpectedValueException;

class TimestampType extends ScalarType
{
    public $name = 'Timestamp';
    public $description = 'The Timestamp scalar type represents a datetime, represented as an ISO8601 timestamp with timezone.';

    public function serialize($value)
    {
        return $this->parseValue($value)->format(DateTime::ATOM);
    }

    public function parseValue($value)
    {
        try {
            return new DateTimeImmutable($value);
        } catch (Exception $e) {
            throw new UnexpectedValueException(
                'Cannot represent value as timestamp: ' . Utils::printSafe($value),
                $e->getCode(),
                $e
            );
        }
    }

    public function parseLiteral($valueNode)
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error("Query error: Can only parse strings, got: {$valueNode->kind}", [$valueNode]);
        }

        try {
            return new DateTimeImmutable($value->value);
        } catch (Exception $e) {
            throw new Error("Not a valid timestamp", [$valueNode]);
        }
    }
}
