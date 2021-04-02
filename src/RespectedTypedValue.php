<?php
declare(strict_types=1);

namespace dzentota\TypedValue;

use Respect\Validation\Validatable;

/**
 * Trait RespectedTypedValue
 * @package dzentota\TypedValue
 */
trait RespectedTypedValue
{
    use TypedValue;

    /**
     * @param $value
     * @return bool
     */
    public static function validate($value): bool
    {
        return static::getValidator()->validate($value);
    }

    /**
     * @return Validatable
     */
    abstract public static function getValidator(): Validatable;

    /**
     * @param $value
     */
    public static function assert($value)
    {
        static::getValidator()->assert($value);
    }

}
