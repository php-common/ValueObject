<?php

namespace Common\ValueObject\Internet;

use Common\ValueObject\ValueObject;
use InvalidArgumentException;

/**
 * Represents an URL.
 *
 * @author Marcos Passos <marcos@marcospassos.com>
 */
final class Url implements ValueObject
{
    /**
     * @var string
     */
    private $url;

    /**
     * Constructor.
     *
     * @param string $url The URL.
     */
    public function __construct($url)
    {
        if (false === filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL.');
        }

        $this->url = (string) $url;
    }

    /**
     * Parses an URL into an object.
     *
     * @param string $url The URL.
     *
     * @return Email
     */
    public static function fromString($url)
    {
        return new self($url);
    }

    /**
     * Returns the scheme (e.g. http).
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->getComponent(PHP_URL_SCHEME);
    }

    /**
     * Returns the user.
     *
     * @return string|null
     */
    public function getUser()
    {
        return $this->getComponent(PHP_URL_USER);
    }

    /**
     * Returns the password.
     *
     * @return string|null
     */
    public function getPassword()
    {
        return $this->getComponent(PHP_URL_PASS);
    }

    /**
     * Returns the host.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->getComponent(PHP_URL_HOST);
    }

    /**
     * Returns the port.
     *
     * @return string|null
     */
    public function getPort()
    {
        return $this->getComponent(PHP_URL_PORT);
    }

    /**
     * Returns the path.
     *
     * @return string|null
     */
    public function getPath()
    {
        return $this->getComponent(PHP_URL_PATH);
    }

    /**
     * Returns the query.
     *
     * @return string|null
     */
    public function getQuery()
    {
        return $this->getComponent(PHP_URL_QUERY);
    }

    /**
     * Returns the fragment.
     *
     * @return string|null
     */
    public function getFragment()
    {
        return $this->getComponent(PHP_URL_FRAGMENT);
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
     * Returns the URL as string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->url;
    }

    /**
     * Extracts a component from the URL.
     *
     * @param string $component The component.
     *
     * @return string|null
     */
    private function getComponent($component)
    {
        return parse_url($this->url, $component);
    }
}