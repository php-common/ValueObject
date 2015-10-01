<?php

namespace Common\ValueObject\Internet;

/**
 * Represents an IP address.
 *
 * @author Marcos Passos <marcos@marcospassos.com>
 *
 * @see   https://en.wikipedia.org/wiki/Internet_Protocol
 */
class Ip
{
    /**
     * Represents the version 4 of the protocol.
     */
    const IPV4 = 4;

    /**
     * Represents the version 6 of the protocol.
     */
    const IPV6 = 6;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $version;

    /**
     * Constructor.
     *
     * @param string $address The IP address.
     */
    public function __construct($address)
    {
        if (false === filter_var($address, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException('Invalid IP address.');
        }

        $version = self::IPV6;
        if (false === filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $version = self::IPV4;
        }

        $this->address = (string) $address;
        $this->version = $version;

    }

    /**
     * Parses an IP address into an object.
     *
     * @param string $address The IP address.
     *
     * @return Ip
     */
    public static function fromString($address)
    {
        return new self($address);
    }

    /**
     * Returns the IP version.
     *
     * @return integer
     *
     * @see Ip::IPV4
     * @see Ip::IPV6
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Returns the email address as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->address;
    }
}
