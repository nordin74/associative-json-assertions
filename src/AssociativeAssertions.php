<?php

namespace AssociativeAssertions;

class AssociativeAssertions
{
    /**
     * @return \Closure
     */
    public static function assertString()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertIsString($actual, $message);
        };
    }


    /**
     * @return \Closure
     */
    public static function assertInt()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertIsInt($actual, $message);
        };
    }


    /**
     * @return \Closure
     */
    public static function assertDigit()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertDigit($actual, $message);
        };
    }


    /**
     * @param string $pattern
     *
     * @return \Closure
     */
    public static function assertRegExp($pattern)
    {
        return function () use ($pattern) {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertMatchesRegularExpression($pattern, $actual, $message);
        };
    }


    /**
     * @return \Closure
     */
    public static function assertBoolean()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertIsBool($actual, $message);
        };
    }


    /**
     * @param string $format
     *
     * @return \Closure
     */
    public static function assertDateTimeStr($format)
    {
        return function () use ($format) {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertDateTimeStr($format, $actual, $message);
        };
    }


    /**
     * @param mixed $type
     *
     * @return \Closure
     */
    public static function assertOptional($type)
    {
        return function ($actual, $message = '') use ($type) {
            AbstractAssociativeArray::assertOptional($type, $actual, $message);
        };
    }


    /**
     * @return \Closure
     */
    public static function assertFloat()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertIsFloat($actual, $message);
        };
    }


    /**
     * @return \Closure
     */
    public static function assertArray()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertIsArray($actual, $message);
        };
    }


    /**
     * @return \Closure
     */
    public static function assertScalar()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertIsScalar($actual, $message);
        };
    }


    /**
     * @return \Closure
     */
    public static function assertObject()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertIsObject($actual, $message);
        };
    }


    /**
     * @return \Closure
     */
    public static function assertCallable()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertIsCallable($actual, $message);
        };
    }


    /**
     * @return \Closure
     */
    public static function assertResource()
    {
        return function () {
            $args    = func_get_args();
            $actual  = $args[0];
            $message = $args[1];
            AbstractAssociativeArray::assertIsResource($actual, $message);
        };
    }
}