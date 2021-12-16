<?php

namespace Shield1739\UTP\CitasCss\fluentpdo\queries;

use Shield1739\UTP\CitasCss\fluentpdo\
{FluentPdoException, Literal, Query};
use PDOStatement;

/**
 * UPDATE query builder
 *
 * @method Update  leftJoin(string $statement) add LEFT JOIN to query
 *                        ($statement can be 'table' name only or 'table:' means back reference)
 * @method Update  innerJoin(string $statement) add INNER JOIN to query
 *                        ($statement can be 'table' name only or 'table:' means back reference)
 * @method Update  orderBy(string $column) add ORDER BY to query
 * @method Update  limit(int $limit) add LIMIT to query
 */
class Update extends Common
{

    /**
     * UpdateQuery constructor
     *
     * @param Query $fluent
     * @param string $table
     */
    public function __construct(Query $fluent, string $table)
    {
        $clauses = [
            'UPDATE' => [$this, 'getClauseUpdate'],
            'JOIN' => [$this, 'getClauseJoin'],
            'SET' => [$this, 'getClauseSet'],
            'WHERE' => [$this, 'getClauseWhere'],
            'ORDER BY' => ', ',
            'LIMIT' => null,
        ];
        parent::__construct($fluent, $clauses);

        $this->statements['UPDATE'] = $table;

        $tableParts = explode(' ', $table);
        $this->joins[] = end($tableParts);
    }

    /**
     * In Update's case, parameters are not assigned until the query is built, since this method
     *
     * @param array|string $fieldOrArray
     * @param bool|string $value
     *
     * @return $this
     * @throws FluentPdoException
     *
     */
    public function set(array|string $fieldOrArray, bool|string $value = false): static
    {
        if (!$fieldOrArray)
        {
            return $this;
        }
        if (is_string($fieldOrArray) && $value !== false)
        {
            $this->statements['SET'][$fieldOrArray] = $value;
        }
        else
        {
            if (!is_array($fieldOrArray))
            {
                throw new FluentPdoException('You must pass a value, or provide the SET list as an associative array. column => value');
            }
            else
            {
                foreach ($fieldOrArray as $field => $value)
                {
                    $this->statements['SET'][$field] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * Execute update query
     *
     * @param boolean $getResultAsPdoStatement true to return the pdo statement instead of row count
     *
     * @return int|boolean|\PDOStatement
     * @throws FluentPdoException
     *
     */
    public function execute($getResultAsPdoStatement = false): int|bool|PDOStatement
    {
        if (empty($this->statements['WHERE']))
        {
            throw new FluentPdoException('Update queries must contain a WHERE clause to prevent unwanted data loss');
        }

        $result = parent::execute();

        if ($getResultAsPdoStatement)
        {
            return $result;
        }

        if ($result)
        {
            return $result->rowCount();
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getClauseUpdate(): string
    {
        return 'UPDATE ' . $this->statements['UPDATE'];
    }

    /**
     * @return string
     */
    protected function getClauseSet(): string
    {
        $setArray = [];
        foreach ($this->statements['SET'] as $field => $value)
        {
            // named params are being used here
            if (is_array($value) && str_starts_with(key($value), ':'))
            {
                $key = key($value);
                $setArray[] = $field . ' = ' . $key;
                $this->parameters['SET'][$key] = $value[$key];
            }
            else if ($value instanceof Literal)
            {
                $setArray[] = $field . ' = ' . $value;
            }
            else
            {
                $setArray[] = $field . ' = ?';
                $this->parameters['SET'][$field] = $value;
            }
        }

        return ' SET ' . implode(', ', $setArray);
    }

}
