<?php

namespace AssociativeAssertions\Constraint;

use PHPUnit\Framework\Constraint\Constraint;


class Digit extends Constraint
{
    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other Value or object to evaluate.
     *
     * @return bool
     */
    protected function matches($other)
    {
        return ctype_digit($other);
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString()
    {
        return 'is a valid string integer';
    }
}