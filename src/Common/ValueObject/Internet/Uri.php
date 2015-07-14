<?php

namespace Common\ValueObject\Internet;

use Common\ValueObject\ValueObject;

final class Uri implements ValueObject
{
    private $uri;

    public function __construct($uri)
    {
        if (false === filter_var($uri, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid IP address.');
        }

        $this->uri = (string) $uri;
    }

    public static function fromString($email)
    {
        return new self($email);
    }

    public function equals($other)
    {
        if (!$other instanceof self) {
            return false;
        }

        return (string) $this === (string) $other;
    }

    public function __toString()
    {
        return $this->uri;
    }
}