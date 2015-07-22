<?php

namespace Common\ValueObject\Device;

use Common\ValueObject\ValueObject;
use InvalidArgumentException;

/**
 * Represents the screen resolution of a device in height and width, expressed in pixels.
 *
 * @author Marcos Passos <marcos@marcospassos.com>
 *
 * @see    https://en.wikipedia.org/wiki/Display_resolution
 */
final class Resolution implements ValueObject
{
    /**
     * The screen resolution's widget, expressed in pixels.
     *
     * @var integer
     */
    protected $width;

    /**
     * The screen resolution's height, expressed in pixels.
     *
     * @var integer
     */
    protected $height;

    /**
     * Constructor.
     *
     * @param integer $width  The screen resolution's width, expressed in pixels.
     * @param integer $height The screen resolution's height, expressed in pixels.
     *
     * @throws InvalidArgumentException If the resolution's width is invalid.
     * @throws InvalidArgumentException If the resolution's height is invalid.
     */
    public function __construct($width, $height)
    {
        if ($width < 1) {
            throw new InvalidArgumentException(sprintf(
                'The resolution\'s width must be an integer greater than zero, got %s.',
                $width
            ));
        }

        if ($height < 1) {
            throw new InvalidArgumentException(sprintf(
                'The resolution\'s height must be an integer greater than zero, got %s.',
                $width
            ));
        }

        $this->width = (integer) $width;
        $this->height = (integer) $height;
    }

    /**
     * Parses a resolution string into an object.
     *
     * @param string $resolution The resolution string.
     *
     * @return Resolution
     *
     * @throws InvalidArgumentException If the resolution string is malformed.
     */
    static public function fromString($resolution)
    {
        if (!preg_match('/[0-9]+x[0-9+]/', $resolution)) {
            throw new InvalidArgumentException(sprintf(
                'Malformed resolution string "%s".',
                $resolution
            ));
        }

        list($width, $height) = sscanf($resolution, '%dx%d');

        return new self($width, $height);
    }

    /**
     * Returns the screen resolution's widget, expressed in pixels.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
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
     * Returns the string representation of the resolution.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->width . 'x' . $this->height;
    }
}