<?php

namespace Shield1739\UTP\CitasCss\fluentpdo\queries;

use ArrayIterator;
use Countable;
use Shield1739\UTP\CitasCss\fluentpdo\
{FluentPdoException, Query, Utilities};
use PDO;
use PDOStatement;

/**
 * SELECT query builder
 */
class Select extends Common implements Countable
{
    private bool $distinct;

    private mixed $fromTable;
    private mixed $fromAlias;

    /**
     * SelectQuery constructor.
     *
     * @param Query $fluent
     * @param           $from
     */
    function __construct(Query $fluent, $from)
    {
        $clauses = [
            'SELECT' => ', ',
            'SELECT DISTINCT' => ', ',
            'FROM' => null,
            'JOIN' => [$this, 'getClauseJoin'],
            'WHERE' => [$this, 'getClauseWhere'],
            'GROUP BY' => ',',
            'HAVING' => ' AND ',
            'ORDER BY' => ', ',
            'LIMIT' => null,
            'OFFSET' => null,
            "\n--" => "\n--"
        ];
        parent::__construct($fluent, $clauses);

        $this->distinct = false;

        // initialize statements
        $fromParts = explode(' ', $from);
        $this->fromTable = reset($fromParts);
        $this->fromAlias = end($fromParts);

        $this->statements['FROM'] = $from;
        $this->statements['SELECT'][] = $this->fromAlias . '.*';
        $this->joins[] = $this->fromAlias;
    }

    /**
     * @param mixed $columns
     * @param bool $overrideDefault
     *
     * @return $this
     */
    public function select(mixed $columns, bool $overrideDefault = false): static
    {
        $clause = 'SELECT';
        if ($this->distinct)
        {
            $clause = 'SELECT DISTINCT';
        }

        if ($overrideDefault === true)
        {
            $this->resetClause($clause);
        }
        else if ($columns === null)
        {
            return $this->resetClause($clause);
        }

        $this->addStatement($clause, $columns, []);

        return $this;
    }

    /**
     * Return table name from FROM clause
     */
    public function getFromTable()
    {
        return $this->fromTable;
    }

    /**
     * Return table alias from FROM clause
     */
    public function getFromAlias()
    {
        return $this->fromAlias;
    }

    /**
     * Returns a single column
     *
     * @param int $columnNumber
     *
     * @return string
     * @throws FluentPdoException
     *
     */
    public function fetchColumn(int $columnNumber = 0): string
    {
        if (($s = $this->execute()) !== false)
        {
            return $s->fetchColumn($columnNumber);
        }

        return $s;
    }

    /**
     * Fetch first row or column
     *
     * @param ?string $column - column name or empty string for the whole row
     * @param int $cursorOrientation
     *
     * @return mixed string, array or false if there is no row
     * @throws FluentPdoException
     *
     */
    public function fetch(?string $column = null, int $cursorOrientation = PDO::FETCH_ORI_NEXT): mixed
    {
        if ($this->result === null)
        {
            $this->execute();
        }

        if ($this->result === false)
        {
            return false;
        }

        $row = $this->result->fetch($this->currentFetchMode, $cursorOrientation);

        if ($this->fluent->convertRead === true)
        {
            $row = Utilities::stringToNumeric($this->result, $row);
        }

        if ($row && $column !== null)
        {
            if (is_object($row))
            {
                return $row->{$column};
            }
            else
            {
                return $row[$column];
            }
        }

        return $row;
    }

    /**
     * Fetch pairs
     *
     * @param $key
     * @param $value
     * @param bool $object
     *
     * @return array|\PDOStatement
     * @throws FluentPdoException
     *
     */
    public function fetchPairs($key, $value, bool $object = false): array|PDOStatement
    {
        if (($s = $this->select("$key, $value", true)->asObject($object)->execute()) !== false)
        {
            return $s->fetchAll(PDO::FETCH_KEY_PAIR);
        }

        return $s;
    }

    /** Fetch all row
     *
     * @param string $index - specify index column. Allows for data organization by field using 'field[]'
     * @param string $selectOnly - select columns which could be fetched
     *
     * @return array|bool -  fetched rows
     * @throws FluentPdoException
     *
     */
    public function fetchAll(string $index = '', string $selectOnly = ''): bool|array
    {
        $indexAsArray = strpos($index, '[]');

        if ($indexAsArray !== false)
        {
            $index = str_replace('[]', '', $index);
        }

        if ($selectOnly)
        {
            $this->select($index . ', ' . $selectOnly, true);
        }

        if ($index)
        {
            return $this->buildSelectData($index, $indexAsArray);
        }
        else
        {
            if (($result = $this->execute()) !== false)
            {
                if ($this->fluent->convertRead === true)
                {
                    return Utilities::stringToNumeric($result, $result->fetchAll());
                }
                else
                {
                    return $result->fetchAll();
                }
            }

            return false;
        }
    }

    /**
     * \Countable interface doesn't break current select query
     *
     * @return int
     * @throws FluentPdoException
     *
     */
    public function count(): int
    {
        $fluent = clone $this;

        return (int)$fluent->select('COUNT(*)', true)->fetchColumn();
    }

    /**
     * @return \ArrayIterator|\PDOStatement
     * @throws FluentPdoException
     *
     */
    public function getIterator(): ArrayIterator|PDOStatement
    {
        if ($this->fluent->convertRead === true)
        {
            return new ArrayIterator($this->fetchAll());
        }
        else
        {
            return $this->execute();
        }
    }

    /**
     * @param $index
     * @param $indexAsArray
     *
     * @return array
     */
    private function buildSelectData($index, $indexAsArray): array
    {
        $data = [];

        foreach ($this as $row)
        {
            if (is_object($row))
            {
                $key = $row->{$index};
            }
            else
            {
                $key = $row[$index];
            }

            if ($indexAsArray)
            {
                $data[$key][] = $row;
            }
            else
            {
                $data[$key] = $row;
            }
        }

        return $data;
    }

    public function distinct(bool $distinct = false): static
    {
        if ($this->distinct === $distinct)
        {
            return $this;
        }

        $this->distinct = $distinct;

        if ($distinct)
        {
            $this->statements['SELECT DISTINCT'] = $this->statements['SELECT'];
            $this->parameters['SELECT DISTINCT'] = $this->parameters['SELECT'];
            $this->statements['SELECT'] = [];
            $this->parameters['SELECT'] = [];
        }
        else
        {
            $this->statements['SELECT'] = $this->statements['SELECT DISTINCT'];
            $this->parameters['SELECT'] = $this->parameters['SELECT DISTINCT'];
            $this->statements['SELECT DISTINCT'] = [];
            $this->parameters['SELECT DISTINCT'] = [];
        }

        return $this;
    }

}
