<?php

namespace Shield1739\UTP\CitasCss\fluentpdo\queries;

use Shield1739\UTP\CitasCss\fluentpdo\
{Query};

/**
 * Class Json
 *
 * @package Envms\FluentPDO\Queries
 */
class Json extends Common
{
    protected mixed $fromTable;
    protected mixed $fromAlias;
    protected bool $convertTypes = false;

    /**
     * Json constructor
     *
     * @param Query $fluent
     * @param string $table
     */
    public function __construct(Query $fluent, string $table)
    {
        $clauses = [
            'SELECT' => ', ',
            'JOIN' => [$this, 'getClauseJoin'],
            'WHERE' => [$this, 'getClauseWhere'],
            'GROUP BY' => ',',
            'HAVING' => ' AND ',
            'ORDER BY' => ', ',
            'LIMIT' => null,
            'OFFSET' => null,
            "\n--" => "\n--",
        ];

        parent::__construct($fluent, $clauses);

        // initialize statements
        $tableParts = explode(' ', $table);
        $this->fromTable = reset($tableParts);
        $this->fromAlias = end($tableParts);

        $this->statements['SELECT'][] = '';
        $this->joins[] = $this->fromAlias;

        if (isset($fluent->convertTypes) && $fluent->convertTypes)
        {
            $this->convertTypes = true;
        }
    }

}