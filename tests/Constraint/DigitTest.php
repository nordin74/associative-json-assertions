<?php

namespace AssociativeAssertions\Tests\Constraint;

use AssociativeAssertions\Constraint\Digit;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestFailure;

class DigitTest extends TestCase
{
    public function testConstraint()
    {
        $constraint = new Digit();
        $this->assertFalse($constraint->evaluate(11, '', true));
        $this->assertTrue($constraint->evaluate('12', '', true));
        $this->assertEquals('is a valid string integer', $constraint->toString());
        $this->assertCount(1, $constraint);

        $other = '567,89';
        try {
            $constraint->evaluate($other);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                "Failed asserting that '$other' is a valid string integer.\n",
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
