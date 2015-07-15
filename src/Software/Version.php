<?php

namespace Common\ValueObject\Software;

use Common\ValueObject\ValueObject;

/**
 * Represents software version, in compliance with the
 * Semantic Versioning Specification.
 *
 * @author Marcos Passos <marcos@marcospassos.com>
 *
 * @see    http://semver.org/
 */
final class Version implements ValueObject
{
    /**
     * Regular expression for a valid semantic version number.
     */
    const VERSION_REGEX = '/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(?:-([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?(?:\+([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?$/';

    /**
     * The build metadata identifiers.
     *
     * @var array
     */
    protected $build;

    /**
     * The major version number.
     *
     * @var integer
     */
    protected $major;

    /**
     * The minor version number.
     *
     * @var integer
     */
    protected $minor;

    /**
     * The patch version number.
     *
     * @var integer
     */
    protected $patch;

    /**
     * The pre-release version identifiers.
     *
     * @var array
     */
    protected $preRelease;

    /**
     * Sets the version information.
     *
     * @param integer $major The major version number.
     * @param integer $minor The minor version number.
     * @param integer $patch The patch version number.
     * @param array   $pre   The pre-release version identifiers.
     * @param array   $build The build metadata identifiers.
     */
    public function __construct($major = 0, $minor = 0, $patch = 0, array $pre = [], array $build = [])
    {
        $this->build = $build;
        $this->major = (integer) $major;
        $this->minor = (integer) $minor;
        $this->patch = (integer) $patch;
        $this->preRelease = $pre;
    }

    /**
     * Parses a semantic version number into an object.
     *
     * @param string $version The version number.
     *
     * @return Version
     */
    static public function fromString($version)
    {
        if (!preg_match(self::VERSION_REGEX, $version)) {
            throw new \InvalidArgumentException(sprintf(
                'Malformed version number string "%s".',
                $version
            ));
        }

        $build = [];
        if (false !== strpos($version, '+')) {
            list($version, $build) = explode('+', $version);
            $build = explode('.', $build);
        }

        $pre = [];
        if (false !== strpos($version, '-')) {
            list($version, $pre) = explode('-', $version);
            $pre = explode('.', $pre);
        }

        list($major,$minor, $patch) = explode('.', $version);

        return new self($major, $minor, $patch, $pre, $build);
    }

    /**
     * Returns the build metadata identifiers.
     *
     * @return array The build metadata identifiers.
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * Returns the major version number.
     *
     * @return integer
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * Returns the minor version number.
     *
     * @return integer
     */
    public function getMinor()
    {
        return $this->minor;
    }
    /**
     * Returns the patch version number.
     *
     * @return integer
     */
    public function getPatch()
    {
        return $this->patch;
    }

    /**
     * Returns the pre-release version identifiers.
     *
     * @return array
     */
    public function getPreRelease()
    {
        return $this->preRelease;
    }

    /**
     * Checks if the version number is stable.
     *
     * @return boolean TRUE if it is stable, FALSE otherwise.
     */
    public function isStable()
    {
        return empty($this->preRelease) && $this->major !== 0;
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
     * Returns the version as string.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%d.%d.%d%s%s',
            $this->major,
            $this->minor,
            $this->patch,
            $this->preRelease
                ? '-' . join('.', $this->preRelease)
                : '',
            $this->build
                ? '+' . join('.', $this->build)
                : ''
        );
    }
}