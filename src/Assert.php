<?php

namespace Atournayre\Assert;

use Webmozart\Assert\InvalidArgumentException;
use function sprintf;

class Assert extends \Webmozart\Assert\Assert
{
    public const TYPE_STRING = 'string';
    public const TYPE_INT = 'int';
    public const TYPE_FLOAT = 'float';
    public const TYPE_BOOL = 'bool';
    public const TYPE_ARRAY = 'array';
    public const TYPE_NULL = 'null';
    public const TYPE_OBJECT = 'object';

    private static array $primitiveTypes = [
        self::TYPE_STRING,
        self::TYPE_INT,
        self::TYPE_FLOAT,
        self::TYPE_BOOL,
        self::TYPE_ARRAY,
        self::TYPE_NULL,
        self::TYPE_OBJECT,
    ];

    /**
     * @param array  $array
     * @param string $classOrType
     * @param string $message
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public static function isListOf(array $array, string $classOrType, string $message = ''): void
    {
        $message = $message ?: sprintf('Expected list - non-associative array of %s.', $classOrType);
        static::isList($array, $message);

        if (in_array($classOrType, self::$primitiveTypes, true)) {
            static::allIsType($array, $classOrType, $message);
            return;
        }
        static::allIsInstanceOf($array, $classOrType, $message);
    }

    /**
     * @param array  $array
     * @param string $classOrType
     * @param string $message
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public static function isMapOf(array $array, string $classOrType, string $message = ''): void
    {
        $message = $message ?: sprintf('Expected map - associative array with string keys of %s.'.print_r($array, true), $classOrType);
        static::isMap($array, $message);

        if (in_array($classOrType, self::$primitiveTypes, true)) {
            static::allIsType($array, $classOrType, $message);
            return;
        }
        static::allIsInstanceOf($array, $classOrType, $message);
    }

    /**
     * @param mixed  $value
     * @param string $type
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function isType(mixed $value, string $type, string $message = ''): void
    {
        switch ($type) {
            case 'string':
                static::string($value, $message);
                break;
            case 'int':
                static::integer($value, $message);
                break;
            case 'float':
                static::float($value, $message);
                break;
            case 'bool':
                static::boolean($value, $message);
                break;
            case 'array':
                static::isArray($value, $message);
                break;
            case 'object':
                static::object($value, $message);
                break;
            case 'null':
                static::null($value, $message);
                break;
            default:
                throw new InvalidArgumentException(sprintf(
                    'Invalid type "%s". Expected one of "string", "int", "float", "bool", "array", "object" or "null".',
                    $type
                ));
        }
    }

    /**
     * @param mixed  $value
     * @param string $type
     * @param string $message
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public static function allIsType(mixed $value, string $type, string $message = ''): void
    {
        if (!\is_array($value)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid type "%s". Expected array.',
                \gettype($value)
            ));
        }

        foreach ($value as $element) {
            static::isType($element, $type, $message);
        }
    }
}
