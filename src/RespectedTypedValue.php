<?php
declare(strict_types=1);

namespace dzentota\TypedValue;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

/**
 * Trait RespectedTypedValue
 * @package dzentota\TypedValue
 */
trait RespectedTypedValue
{
    use TypedValue;

    public static function validate($value): ValidationResult
    {
        $result = new ValidationResult();
        try {
            static::getValidator()->assert($value);
        } catch (NestedValidationException $exception) {
            foreach ($exception->getMessages() as $name => $message) {
                $result->addError($message, $name);
            }
        }
        return $result;
    }

    /**
     * @return Validator
     */
    abstract public static function getValidator(): Validator;

}
