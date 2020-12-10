<?php

namespace AssociativeAssertions\Constraint;

use PHPUnit\Framework\Constraint\Constraint;


class DateTimeStr extends Constraint
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @param string $format
     */
    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other Value or object to evaluate.
     *
     * @return bool
     */
    protected function matches($other): bool
    {
        $dateTime = \DateTime::createFromFormat($this->format, $other);

        return (isset($dateTime) && $dateTime->format($this->format) == $other);
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString(): string
    {
        return \sprintf('is a valid date with format "%s"', $this->format);
    }
}