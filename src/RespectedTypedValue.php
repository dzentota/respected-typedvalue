<?php
declare(strict_types=1);

namespace dzentota\TypedValue;

use Respect\Validation\Validatable;

trait RespectedTypedValue
{
    use TypedValue;

    public static function validate($value): bool
    {
        return static::getValidator()->validate($value);
    }

    abstract public static function getValidator(): Validatable;

    public static function assert($value)
    {
        static::getValidator()->assert($value);
    }

}
