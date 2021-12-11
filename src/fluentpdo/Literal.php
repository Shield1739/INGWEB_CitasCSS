<?php

namespace Shield1739\UTP\CitasCss\fluentpdo;

/**
 * SQL literal value
 */
class Literal
{
    protected string $value;

    /**
     * Create literal value
     *
     * @param string $value
     */
    function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Get literal value
     *
     * @return string
     */
    function __toString()
    {
        return $this->value;
    }

}
