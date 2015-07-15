<?php

namespace Common\ValueObject\Person;

use Common\ValueObject\ValueObject;

/**
 * Represents a person name.
 *
 * @author Marcos Passos <marcos@marcospassos.com>
 */
final class Name implements ValueObject, \IteratorAggregate
{
    /**
     * The first name.
     *
     * @var string
     */
    private $first;

    /**
     * The middle name.
     *
     * @var string|null
     */
    private $middle;

    /**
     * The last name.
     *
     * @var string|null
     */
    private $last;

    /**
     * Constructor.
     *
     * @param string $first  The first name.
     * @param string $middle The middle name.
     * @param string $last   The last name.
     */
    public function __construct($first, $middle = null, $last = null)
    {
        $this->first = (string) $first;
        $this->middle = !empty($middle) ? (string) $middle : null;
        $this->last = !empty($middle) ? (string) $last : null;
    }

    /**
     * Parses a name into an object.
     *
     * @param string $name The full name.
     *
     * @return Name
     */
    public static function fromString($name)
    {
        $parts = array_merge(array_fill(0, 3, null), preg_split('/\s+/', $name));

        $first = array_shift($parts);
        $last = array_pop($parts);
        $middle = implode(' ', $parts);

        return new self($first, $middle, $last);
    }

    /**
     * Returns the first name.
     *
     * @return string
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * Returns the middle name.
     *
     * @return string|null
     */
    public function getMiddle()
    {
        return $this->middle;
    }

    /**
     * Returns the last name.
     *
     * @return string|null
     */
    public function getLast()
    {
        return $this->last;
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
     * Returns the name as array.
     *
     * @return array
     */
    protected function toArray()
    {
        return [$this->first, $this->middle, $this->last];
    }

    /**
     * Returns the name as string.
     *
     * @return string
     */
    public function __toString()
    {
        return implode(' ', array_filter($this->toArray()));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }
}