<?php

namespace Common\ValueObject\Geography;

use InvalidArgumentException;

/**
 * Represents a geographic location point.
 *
 * @author Marcos Passos <marcos@croct.com>
 *
 * @see   https://en.wikipedia.org/wiki/Geographic_coordinate_system
 */
class Point
{
    /**
     * The latitude of the location.
     *
     * @var float
     */
    private $latitude;

    /**
     * The longitude of the location.
     *
     * @var float
     */
    private $longitude;

    /**
     * @param float $latitude  The latitude of the location, must range from -90 to 90.
     * @param float $longitude The longitude of the location, must range from -180 to 180.
     *
     * @throws InvalidArgumentException When the latitude is invalid.
     * @throws InvalidArgumentException When the longitude is invalid.
     */
    public function __construct($latitude, $longitude)
    {
        if (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
            throw new InvalidArgumentException(sprintf(
                'The latitude must range from -90 to 90, but %f given.',
                $latitude
            ));
        }

        if (!is_numeric($longitude) ||  $longitude < -180 || $longitude > 180) {
            throw new InvalidArgumentException(sprintf(
                'The longitude must range from -180 to 180, but %f given.',
                $longitude
            ));
        }

        $this->latitude = (float) $latitude;
        $this->longitude = (float) $longitude;
    }

    /**
     * Parses a geographic location point into an object.
     *
     * @param string $point The geographic location point.
     *
     * @return Point
     */
    public function fromString($point)
    {
        if (!preg_match('/[0-9]+\.[0-9]+ [0-9]+\.[0-9]+/', $point)) {
            throw new InvalidArgumentException('Invalid point.');
        }

        list($latitude, $longitude) = sscanf($point, '%f %f');

        return new self($latitude, $longitude);
    }

    /**
     * Gets the latitude.
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Gets the longitude.
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Returns the geographic point as string.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%f %f', $this->latitude, $this->longitude);
    }
}