<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace tests\dzentota\TypedValue;

use dzentota\TypedValue\RespectedTypedValue;
use dzentota\TypedValue\Typed;
use PHPUnit\Framework\TestCase;
use Respect\Validation\Validatable;
use Respect\Validation\Validator;

final class RespectedTypedValueTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = RespectedStringValue::fromNative('foo');
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $test1 = RespectedStringValue::fromNative('foo');
        $test2 = RespectedStringValue::fromNative('bar');

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $test1 = RespectedStringValue::fromNative('foo');
        $test2 = RespectedStringValue::fromNative('foo');

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_from_native_throws_exception_when_given_non_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        RespectedStringValue::fromNative(1000);
    }

    public function test_to_native_returns_original_value()
    {
        $native = 'foo';
        $stringValue = RespectedStringValue::fromNative($native);
        $this->assertEquals($native, $stringValue->toNative());
    }
}

final class RespectedStringValue implements Typed
{
    use RespectedTypedValue;

    public static function getValidator(): Validatable
    {
        return Validator::create()->notEmpty()->stringType();
    }
}
