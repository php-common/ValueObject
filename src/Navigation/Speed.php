<?php

namespace Common\ValueObject\Navigation;

use Common\ValueObject\ValueObject;
use InvalidArgumentException;

/**
 * Represents the speed at which the object is moving in meters per second.
 *
 * @author Marcos Passos <marcos@marcospassos.com>
 *
 * @see    https://en.wikipedia.org/wiki/Geographic_coordinate_system
 */
class Speed implements ValueObject
{
    /**
     * The speed value.
     *
     * @var float
     */
    private $value;

    /**
     * Constructor.
     *
     * @param float $value The speed value.
     */
    public function __construct($value)
    {
        if (!is_numeric($value) || $value < 0) {
            throw new InvalidArgumentException(sprintf(
                'The speed must be a positive number, %s given.',
                $value
            ));
        }

        $this->value = $value;
    }

    /**
     * Returns the speed value.
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!$other instanceof self) {
            return false;
        }

        return $this->value === $other->value;
    }

    /**
     * Returns the string representation of the speed.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}