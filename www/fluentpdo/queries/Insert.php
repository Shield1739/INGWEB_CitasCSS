<?php

namespace Shield1739\UTP\CitasCss\fluentpdo\queries;

use Shield1739\UTP\CitasCss\fluentpdo\
{FluentPdoException, Literal, Query};
use JetBrains\PhpStorm\Pure;

/** INSERT query builder
 */
class Insert extends Base
{
    private array $columns;

    private array $firstValue;

    private bool $ignore;
    private bool $delayed;

    /**
     * InsertQuery constructor.
     *
     * @param Query $fluent
     * @param string $table
     * @param           $values
     *
     * @throws FluentPdoException
     */
    public function __construct(Query $fluent, $table, $values)
    {
        $this->columns = [];
        $this->firstValue = [];

        $this->ignore = false;
        $this->delayed = false;

        $clauses = [
            'INSERT INTO' => [$this, 'getClauseInsertInto'],
            'VALUES' => [$this, 'getClauseValues'],
            'ON DUPLICATE KEY UPDATE' => [$this, 'getClauseOnDuplicateKeyUpdate'],
        ];
        parent::__construct($fluent, $clauses);

        $this->statements['INSERT INTO'] = $table;
        $this->values($values);
    }

    /**
     * Force insert operation to fail silently
     *
     * @return Insert
     */
    public function ignore(): static
    {
        $this->ignore = true;

        return $this;
    }

    /** Force insert operation delay support
     *
     * @return Insert
     */
    public function delayed(): static
    {
        $this->delayed = true;

        return $this;
    }

    /**
     * Add VALUES
     *
     * @param $values
     *
     * @return Insert
     * @throws FluentPdoException
     */
    public function values($values): static
    {
        if (!is_array($values))
        {
            throw new FluentPdoException('Param VALUES for INSERT query must be array');
        }

        $first = current($values);
        if (is_string(key($values)))
        {
            // is one row array
            $this->addOneValue($values);
        }
        else if (is_array($first) && is_string(key($first)))
        {
            // this is multi values
            foreach ($values as $oneValue)
            {
                $this->addOneValue($oneValue);
            }
        }

        return $this;
    }

    /**
     * Add ON DUPLICATE KEY UPDATE
     *
     * @param array $values
     *
     * @return Insert
     */
    public function onDuplicateKeyUpdate(array $values): static
    {
        $this->statements['ON DUPLICATE KEY UPDATE'] = array_merge(
            $this->statements['ON DUPLICATE KEY UPDATE'], $values
        );

        return $this;
    }

    /**
     * Execute insert query
     *
     * @param mixed|null $sequence
     *
     * @return int|bool - Last inserted primary key
     * @throws FluentPdoException
     *
     */
    public function execute(mixed $sequence = null): int|bool
    {
        $result = parent::execute();

        if ($result)
        {
            return $this->fluent->getPdo()->lastInsertId($sequence);
        }

        return false;
    }

    /**
     *
     * @return bool
     * @throws FluentPdoException
     *
     */
    public function executeWithoutId(): bool
    {
        $result = parent::execute();

        if ($result)
        {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getClauseInsertInto(): string
    {
        return 'INSERT' . ($this->ignore ? " IGNORE" : '') . ($this->delayed ? " DELAYED" : '') . ' INTO ' . $this->statements['INSERT INTO'];
    }

    /**
     * @return string
     */
    protected function getClauseValues(): string
    {
        $valuesArray = [];
        foreach ($this->statements['VALUES'] as $rows)
        {
            // literals should not be parametrized.
            // They are commonly used to call engine functions or literals.
            // Eg: NOW(), CURRENT_TIMESTAMP etc
            $placeholders = array_map([$this, 'parameterGetValue'], $rows);
            $valuesArray[] = '(' . implode(', ', $placeholders) . ')';
        }

        $columns = implode(', ', $this->columns);
        $values = implode(', ', $valuesArray);

        return " ($columns) VALUES $values";
    }


    /**
     * @return string
     */
    #[Pure] protected function getClauseOnDuplicateKeyUpdate(): string
    {
        $result = [];
        foreach ($this->statements['ON DUPLICATE KEY UPDATE'] as $key => $value)
        {
            $result[] = "$key = " . $this->parameterGetValue($value);
        }

        return ' ON DUPLICATE KEY UPDATE ' . implode(', ', $result);
    }

    /**
     * @param $param
     *
     * @return string
     */
    protected function parameterGetValue($param): string
    {
        return $param instanceof Literal ? (string)$param : '?';
    }

    /**
     * Removes all Literal instances from the argument
     * since they are not to be used as PDO parameters but rather injected directly into the query
     *
     * @param $statements
     *
     * @return array
     */
    protected function filterLiterals($statements): array
    {
        $f = function ($item)
        {
            return !$item instanceof Literal;
        };

        return array_map(function ($item) use ($f)
        {
            if (is_array($item))
            {
                return array_filter($item, $f);
            }

            return $item;
        }, array_filter($statements, $f));
    }

    /**
     * @return array
     */
    protected function buildParameters(): array
    {
        $this->parameters = array_merge(
            $this->filterLiterals($this->statements['VALUES']),
            $this->filterLiterals($this->statements['ON DUPLICATE KEY UPDATE'])
        );

        return parent::buildParameters();
    }

    /**
     * @param array $oneValue
     *
     * @throws FluentPdoException
     */
    private function addOneValue(array $oneValue)
    {
        // check if all $keys are strings
        foreach ($oneValue as $key => $value)
        {
            if (!is_string($key))
            {
                throw new FluentPdoException('INSERT query: All keys of value array have to be strings.');
            }
        }
        if (!$this->firstValue)
        {
            $this->firstValue = $oneValue;
        }
        if (!$this->columns)
        {
            $this->columns = array_keys($oneValue);
        }
        if ($this->columns != array_keys($oneValue))
        {
            throw new FluentPdoException('INSERT query: All VALUES have to same keys (columns).');
        }
        $this->statements['VALUES'][] = $oneValue;
    }

}
