<?php

namespace AssociativeAssertions;

trait AssociativeArrayTrait
{
    public static function assertAssociativeArray($expected, $actual, $message = '')
    {
        AbstractAssociativeArray::assertAssociativeArray($expected, $actual, $message = '');
    }
}