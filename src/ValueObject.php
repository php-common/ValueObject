<?php

namespace Common\ValueObject;

/**
 * Represents a value object which equality is not based on identity, but value.
 *
 * @author Marcos Passos <marcos@croct.com>
 */
interface ValueObject
{
    /**
     * Checks whether a value object is equals to another.
     *
     * @param object $other The value object to compare.
     *
     * @return boolean TRUE if the two value objects are equals, FALSE otherwise.
     */
    public function equals($other);
}