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
        self::assertSame(array_keys($expected), array_keys($actual), $message);
        foreach ($expected as $key => $value) {
            if (\is_array($value)) {
                self::recursiveAssociativeAssertion($expected[$key], $actual[$key], $message);
            } else {
                if (is_callable($value)) {
                    $value($actual[$key], $message);
                } else {
                    self::assertSame($actual[$key], $value, $message);
                }
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
}