<?php

namespace Atournayre\Assert;

use Geocoder\Exception\InvalidArgument;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Bic;
use Symfony\Component\Validator\Constraints\Iban;
use Symfony\Component\Validator\Validation;
use Webmozart\Assert\InvalidArgumentException;
use function gettype;
use function is_array;
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
        if (!is_array($value)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid type "%s". Expected array.',
                gettype($value)
            ));
        }

        foreach ($value as $element) {
            static::isType($element, $type, $message);
        }
    }

    /**
     * @param string                 $string
     * @param array<int, Constraint> $constraints
     * @param string                 $message
     *
     * @return void
     */
    public static function throwConstraintViolationList(string $string, array $constraints, string $message = ''): void
    {
        Assert::allIsInstanceOf($constraints, Constraint::class);

        $constraintViolationList = Validation::createValidator()
            ->validate($string, $constraints);

        if (count($constraintViolationList) > 0) {
            $message = $message ?: $constraintViolationList[0]->getMessage();
            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param string $string
     * @param string $message
     *
     * @return void
     */
    public static function isBIC(string $string, string $message = ''): void
    {
        self::throwConstraintViolationList($string, [new Bic()], $message);
    }

    /**
     * @param string $string
     * @param string $message
     *
     * @return void
     */
    public static function isIBAN(string $string, string $message = ''): void
    {
        self::throwConstraintViolationList($string, [new Iban()], $message);
    }

    /**
     * @param float  $value
     * @param string $message
     *
     * @return void
     */
    public static function latitude(float $value, string $message = ''): void
    {
        self::float($value, $message);
        if ($value < -90 || $value > 90) {
            throw new InvalidArgumentException(
                sprintf($message ?: 'Latitude should be between -90 and 90. Got: %s', $value)
            );
        }
    }

    /**
     * @param float  $value
     * @param string $message
     *
     * @return void
     */
    public static function longitude(float $value, string $message = ''): void
    {
        self::float($value, $message);
        if ($value < -180 || $value > 180) {
            throw new InvalidArgumentException(
                sprintf($message ?: 'Longitude should be between -180 and 180. Got: %s', $value)
            );
        }
    }
}
