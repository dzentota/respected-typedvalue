<?php

declare(strict_types=1);

namespace tests\dzentota\TypedValue;

use dzentota\TypedValue\RespectedTypedValue;
use dzentota\TypedValue\Typed;
use PHPUnit\Framework\TestCase;
use Respect\Validation\Validator;

final class RespectedCompositeValueTest extends TestCase
{
    public function test_is_null_returns_false()
    {
        $test = RespectedCompositeValue::fromNative(['email' => 'foo@bar.com', 'url' => 'https://example.com']);
        $this->assertFalse($test->isNull());
    }

    public function test_is_same_returns_false_when_values_mismatch()
    {
        $test1 = RespectedCompositeValue::fromNative(['email' => 'foo@bar.com', 'url' => 'https://example.com']);
        $test2 = RespectedCompositeValue::fromNative(['email' => 'baz@bar.com', 'url' => 'https://example.com']);

        $this->assertFalse($test1->isSame($test2));
    }

    public function test_is_same_returns_true_when_values_match()
    {
        $test1 = RespectedCompositeValue::fromNative(['email' => 'foo@bar.com', 'url' => 'https://example.com']);
        $test2 = RespectedCompositeValue::fromNative(['email' => 'foo@bar.com', 'url' => 'https://example.com']);

        $this->assertTrue($test1->isSame($test2));
    }

    public function test_from_native_throws_exception_when_given_non_array()
    {
        $this->expectException(\InvalidArgumentException::class);
        RespectedCompositeValue::fromNative(1000);
    }

    public function test_to_native_returns_original_value()
    {
        $native = ['email' => 'foo@bar.com', 'url' => 'https://example.com'];
        $compositeValue = RespectedCompositeValue::fromNative($native);
        $this->assertEquals($native, $compositeValue->toNative());
    }
}

final class RespectedCompositeValue implements Typed
{
    use \dzentota\TypedValue\CompositeValue;

    private RespectedEmail $email;
    private RespectedUrl $url;
}

class RespectedEmail implements Typed
{
    use RespectedTypedValue;

    public static function getValidator(): Validator
    {
        return Validator::create()->notEmpty()->email();
    }
}

class RespectedUrl implements Typed
{
    use RespectedTypedValue;

    public static function getValidator(): Validator
    {
        return Validator::create()->notEmpty()->url();
    }
}