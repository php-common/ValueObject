<?php

namespace Common\ValueObject\Misc;

use Common\ValueObject\ValueObject;

/**
 * Represents an unit.
 *
 * @author Marcos Passos <marcos@croct.com>
 */
final class Unit implements ValueObject
{
    // Speed
    const TYPE_SPEED = 1;

    const MILE_PER_HOUR      = 'mph';
    const METER_PER_SECOND   = 'mps';
    const KILOMETER_PER_HOUR = 'kmh';

    /**
     * The unit type.
     *
     * @var string
     */
    private $name;

    /**
     * Constructor.
     *
     * @param string $name The unit type.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the unit type.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the unit's type.
     *
     * @return integer
     */
    public function getType()
    {
        switch($this->name) {
            case self::MILE_PER_HOUR:
            case self::KILOMETER_PER_HOUR:
            case self::METER_PER_SECOND:
                return self::TYPE_SPEED;
        }
    }

    /**
     * Checks whether the unit matches the given type.
     *
     * @param string $type The unit type.
     *
     * @return boolean Returns `true` if the unit matches the given type, `false` otherwise.
     */
    public function isOfType($type)
    {
        return $this->getType() === $type;
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
     * Returns the string representation of unit.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}