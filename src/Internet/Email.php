<?php

namespace Common\ValueObject\Internet;

use Common\ValueObject\ValueObject;

/**
 * Represents an email address.
 *
 * @author Marcos Passos <marcos@croct.com>
 *
 * @see    https://en.wikipedia.org/wiki/Email_address
 */
final class Email implements ValueObject
{
    /**
     * The name of the mailbox.
     *
     * @var string
     */
    private $localpart;

    /**
     * The domain name.
     *
     * @var string
     */
    private $domain;

    /**
     * Constructor.
     *
     * @param string $email The email address.
     */
    public function __construct($email)
    {
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address.');
        }

        list($this->localpart, $this->domain) = explode('@', $email);
    }

    /**
     * Parses an email address into an object.
     *
     * @param string $email The email address.
     *
     * @return Email
     */
    public static function fromString($email)
    {
        return new self($email);
    }

    /**
     * Gets the localpart (the left of the "@").
     *
     * @return string
     */
    public function getLocalpart()
    {
        return $this->localpart;
    }

    /**
     * Gets the domain name (the right of the "@").
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
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
     * Returns the email address as string.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s@%s', $this->localpart, $this->domain);
    }
}