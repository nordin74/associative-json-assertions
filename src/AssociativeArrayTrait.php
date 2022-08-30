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


    /**
     * @param mixed $type
     * @param array $params
     *
     * @return void
     */
    public static function assertOptional($type, $params)
    {
        if (is_string($type) && method_exists(AssociativeAssertions::class, $type)) {
            $mixed = call_user_func_array(__NAMESPACE__ . "\AssociativeAssertions::$type", $params);
        } else {
            $mixed = $type;
        }

        AbstractAssociativeArray::assertOptional($mixed, end($params));
    }
}