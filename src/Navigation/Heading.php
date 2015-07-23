<?php

namespace Common\ValueObject\Navigation;

use Common\ValueObject\ValueObject;
use InvalidArgumentException;

/**
 * Represents a heading.
 *
 * @author Marcos Passos <marcos@marcospassos.com>
 *
 * @see    https://en.wikipedia.org/wiki/Course_(navigation)
 */
class Heading implements ValueObject
{
    /**
     * Towards the north.
     */
    const NORTH = 0;

    /**
     * Towards the east.
     */
    const EAST  = 1;

    /**
     * Towards the south.
     */
    const SOUTH = 2;

    /**
     * Towards the west.
     */
    const WEST  = 3;

    /**
     * The angle in degrees.
     *
     * @var float
     */
    private $angle;

    /**
     * Constructor.
     *
     * @param float $angle The angle in degrees.
     */
    public function __construct($angle)
    {
        if (!is_numeric($angle) || $angle < 0 || $angle > 360) {
            throw new InvalidArgumentException(sprintf(
                'The angle must a number raging from 0 to 360, but got %s.',
                $angle
            ));
        }

        $this->angle = (float) $angle;
    }

    /**
     * Returns the angle in degrees.
     *
     * @return float
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * Returns the direction in relation to the lines of meridian.
     *
     * @return integer
     */
    public function getDirection()
    {
        switch(true) {
            case ($this->angle <= 90):
                return self::NORTH;
            case ($this->angle <= 180):
                return self::EAST;
            case ($this->angle <= 270):
                return self::SOUTH;
            case ($this->angle <= 360):
                return self::WEST;
        }
    }

    /**
     * Checks whether the heading points toward north.
     *
     * @return boolean Returns `true` if the heading points toward north, `false` otherwise.
     */
    public function isNorth()
    {
        return $this->getDirection() === self::NORTH;
    }

    /**
     * Checks whether the heading points toward east.
     *
     * @return boolean Returns `true` if the heading points toward east, `false` otherwise.
     */
    public function isEast()
    {
        return $this->getDirection() === self::EAST;
    }

    /**
     * Checks whether the heading points toward south.
     *
     * @return boolean Returns `true` if the heading points toward south, `false` otherwise.
     */
    public function isSouth()
    {
        return $this->getDirection() === self::SOUTH;
    }

    /**
     * Checks whether the heading points toward west.
     *
     * @return boolean Returns `true` if the heading points toward west, `false` otherwise.
     */
    public function isWest()
    {
        return $this->getDirection() === self::WEST;
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
     * Returns the string representation of the heading.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->angle;
    }
}