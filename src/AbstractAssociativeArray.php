<?php

namespace AssociativeAssertions;

use AssociativeAssertions\Constraint\DateTimeStr;
use AssociativeAssertions\Constraint\Digit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Util\InvalidArgumentHelper;


abstract class AbstractAssociativeArray extends TestCase
{
    /**
     * @param array  $expected
     * @param array  $actual
     * @param string $message
     */
    public static function assertAssociativeArray($expected, $actual, $message = '')
    {
        if (!\is_array($expected)) {
            throw InvalidArgumentHelper::factory(1, 'array');
        }

        if (!\is_array($actual)) {
            throw InvalidArgumentHelper::factory(2, 'array');
        }

        self::recursiveAssociativeAssertion($expected, $actual, $message);
    }


    /**
     * @param array  $expected
     * @param array  $actual
     * @param string $message
     */
    private static function recursiveAssociativeAssertion($expected, $actual, $message = '')
    {
        $diff = array_diff(array_keys($actual), array_keys($expected));
        self::assertTrue(empty($diff), 'The actual array contains unexpected keys.');
        foreach ($expected as $key => $value) {
            if (\is_array($value)) {
                self::recursiveAssociativeAssertion($expected[$key], $actual[$key], $message);
            } else if (is_callable($value)) {
                $reflectionFx = new \ReflectionFunction($value);
                if ($reflectionFx->getNumberOfParameters() && $reflectionFx->getNamespaceName() === __NAMESPACE__) {
                    if (isset($actual[$key])) {
                        $value($actual[$key], $message);
                    }
                } else {
                    $value($actual[$key], $message);
                }
            } else {
                self::assertSame($actual[$key], $value, $message);
            }
        }
    }


    /**
     * @param string $format
     * @param string $actual
     * @param string $message
     */
    public static function assertDateTimeStr($format, $actual, $message = '')
    {
        if (!\is_string($format)) {
            throw InvalidArgumentHelper::factory(1, 'string');
        }

        if (!\is_string($actual)) {
            throw InvalidArgumentHelper::factory(2, 'string');
        }

        $constraint = new DateTimeStr($format);
        self::assertThat($actual, $constraint, $message);
    }


    /**
     * @param string $actual
     * @param string $message
     */
    public static function assertDigit($actual, $message = '')
    {
        $constraint = new Digit();
        self::assertThat($actual, $constraint, $message);
    }


    /**
     * @param mixed $type
     * @param mixed $actual
     * @param string $message
     *
     * @return void
     */
    public static function assertOptional($type, $actual, $message = '')
    {
        if ($actual === null) {
            return;
        }

        if (is_callable($type)) {
            $type($actual, $message);
        } elseif (is_callable($actual)) {
            $actual($type);
        } else {
            self::assertSame($type, $actual, $message);
        }
    }
}