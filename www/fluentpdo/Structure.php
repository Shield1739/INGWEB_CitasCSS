<?php

namespace Shield1739\UTP\CitasCss\fluentpdo;

/**
 * Class Structure
 */
class Structure
{

    private string $primaryKey;
    private string $foreignKey;

    /**
     * Structure constructor
     *
     * @param string $primaryKey
     * @param string $foreignKey
     */
    function __construct(string $primaryKey = '%sID', string $foreignKey = '%sID')
    {
        if ($foreignKey === null)
        {
            $foreignKey = $primaryKey;
        }
        $this->primaryKey = $primaryKey;
        $this->foreignKey = $foreignKey;
    }

    /**
     * @param string $table
     *
     * @return string
     */
    public function getPrimaryKey(string $table): string
    {
        return $this->key($this->primaryKey, $table);
    }

    /**
     * @param string $table
     *
     * @return string
     */
    public function getForeignKey(string $table): string
    {
        return $this->key($this->foreignKey, $table);
    }

    /**
     * @param callback|string $key
     * @param string $table
     *
     * @return string
     */
    private function key(callable|string $key, string $table): string
    {
        if (is_callable($key))
        {
            return $key($table);
        }

        return sprintf($key, $table);
    }

}
