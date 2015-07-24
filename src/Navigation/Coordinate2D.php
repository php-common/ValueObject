<?php

namespace Common\ValueObject\Navigation;

use Common\ValueObject\ValueObject;
use InvalidArgumentException;

/**
 * Represents a geographical coordinate using the WGS 84 reference frame.
 *
 * @author Marcos Passos <marcos@marcospassos.com>
 */
class Coordinate2D implements ValueObject
{
    /**
     * The latitude in degrees.
     *
     * Positive values indicate latitudes north of the equator, while negative
     * values indicate latitudes south of the equator.
     *
     * @var float
     */
    private $latitude;

    /**
     * The longitude in degrees. Measurements are relative to the zero
     * meridian, with positive values extending east of the meridian and
     * negative values extending west of the meridian.
     *
     * @var float
     */
    private $longitude;

    /**
     * Constructor.
     *
     * @param float $latitude  The latitude in degrees, must range from -90 to
     *                         90.
     * @param float $longitude The longitude in degrees, must range from -180
     *                         to 180.
     *
     * @throws InvalidArgumentException  If any of the arguments is invalid.
     */
    public function __construct($latitude, $longitude, $altitude = null)
    {
        if (!is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
            throw new InvalidArgumentException(sprintf(
                'The latitude must be a number ranging from -90 to 90, %s given.',
                $latitude
            ));
        }

        if (!is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
            throw new InvalidArgumentException(sprintf(
                'The longitude must be a number ranging from -180 to 180, %s given.',
                $longitude
            ));
        }

        $this->latitude = (float) $latitude;
        $this->longitude = (float) $longitude;
    }

    /**
     * Parses an string representation of the coordinates in into an object.
     *
     * @param string $coordinates The geographic point.
     *
     * @return Coordinate2D
     *
     * @throws InvalidArgumentException If the coordinates string is malformed.
     */
    public function fromString($coordinates)
    {
        if (!preg_match('/[0-9]+\.[0-9]+ [0-9]+\.[0-9]+', $coordinates)) {
            throw new InvalidArgumentException('Malformed coordinates string.');
        }

        list ($latitude, $longitude) = explode(" ", $coordinates);

        return new self($latitude, $longitude);
    }

    /**
     * Returns the latitude in degrees.
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Returns the longitude in degrees.
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
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
     * Returns the string representation of the coordinate.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%f %f', $this->latitude, $this->longitude);
    }
}