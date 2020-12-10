<?php

namespace AssociativeAssertions\Tests\Constraint;

use AssociativeAssertions\Constraint\DateTimeStr;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestFailure;

class DateTimeStrTest extends TestCase
{
    public function testConstraint()
    {
        $constraint = new DateTimeStr('Y-m-d');
        $this->assertFalse($constraint->evaluate('2018-02-29', '', true));
        $this->assertTrue($constraint->evaluate('2018-02-28', '', true));
        $this->assertEquals('is a valid date with format "Y-m-d"', $constraint->toString());
        $this->assertCount(1, $constraint);

        $other = '2018-04-31';
        try {
            $constraint->evaluate('2018-04-31');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals("Failed asserting that '$other' is a valid date with format \"Y-m-d\".\n",
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
