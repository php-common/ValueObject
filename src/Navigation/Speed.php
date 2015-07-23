<?php

namespace Common\ValueObject\Navigation;

use Common\ValueObject\ValueObject;
use Common\ValueObject\Misc\Unit;
use InvalidArgumentException;

/**
 * Represents a speed value.
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
     * The speed unit.
     *
     * @var Unit
     */
    private $unit;

    /**
     * Constructor.
     *
     * @param float $value The speed value.
     * @param Unit  $unit  The speed unit.
     */
    public function __construct($value, Unit $unit)
    {
        if (!is_numeric($value) || $value < 0) {
            throw new InvalidArgumentException(sprintf(
                'The speed must be a positive number, %s given.',
                $value
            ));
        }

        if (!$unit->isOfType(Unit::TYPE_SPEED)) {
            throw new InvalidArgumentException(sprintf(
                'Expected a valid speed unit, but got %s.',
                $unit
            ));
        }

        $this->value = $value;
        $this->unit = $unit;
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
     * Returns the speed unit.
     *
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!$other instanceof self) {
            return false;
        }

        return (string) $this === (string) $other;
    }

    /**
     * Returns the string representation of the speed.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s %s', $this->value, $this->unit);
    }
}