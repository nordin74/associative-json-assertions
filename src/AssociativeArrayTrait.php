<?php

namespace AssociativeAssertions;

trait AssociativeArrayTrait
{
    /**
     * @param array  $expected
     * @param array  $actual
     * @param string $message
     */
    public static function assertAssociativeArray($expected, $actual, $message = '')
    {
        AbstractAssociativeArray::assertAssociativeArray($expected, $actual, $message);
    }


    /**
     * @param  string $actual
     * @param string  $message
     */
    public static function assertDigit($actual, $message = '')
    {
        AbstractAssociativeArray::assertDigit($actual, $message);
    }


    /**
     * @param string $format
     * @param string $actual
     * @param string $message
     */
    public static function assertDateTimeStr($format, $actual, $message = '')
    {
        AbstractAssociativeArray::assertDateTimeStr($format, $actual, $message);
    }
}