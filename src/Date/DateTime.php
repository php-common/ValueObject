<?php

namespace Common\ValueObject\Date;

use Common\ValueObject\ValueObject;
use DateTimeImmutable;

/**
 * Represents a date-time, often viewed as year-month-day-hour-minute-second.
 *
 * @author Marcos Passos <marcos@croct.com>
 */
final class DateTime extends DateTimeImmutable implements ValueObject
{
    /**
     * Parses an ISO 8601 formatted date-time string into an object.
     *
     * @param string $dateTime The date-time string.
     *
     * @return DateTime
     *
     * @see    http://www.php.net/manual/en/datetime.formats.php
     */
    public function fromString($dateTime)
    {
        return self::createFromFormat(\DateTime::ISO8601, $dateTime);
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!$other instanceof self) {
            return false;
        }

        return $this->getTimestamp() === $other->getTimestamp();
    }

    /**
     * Returns the date-time as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format(\DateTime::ISO8601);
    }
}