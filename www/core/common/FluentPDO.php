<?php

namespace Shield1739\UTP\CitasCss\core\common;

use PDO;
use PDOStatement;
use Shield1739\UTP\CitasCss\core\Database;
use Shield1739\UTP\CitasCss\fluentpdo\queries\Select;
use Shield1739\UTP\CitasCss\fluentpdo\Query;

class FluentPDO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getPDO();
    }

    public function prepare($query): bool|PDOStatement
    {
        return $this->pdo->prepare($query);
    }

    public function getFluentPdoBuilder(): Query
    {
        return new Query($this->pdo);
    }

    /**
     * @throws \Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException
     */
    public function fetchFromWhere(string $tableName, array $where = [], string|bool $asObject = false)
    {
        return $this->fromWhere($tableName, $where, $asObject)->fetch();
    }

    /**
     * @throws \Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException
     */
    public function fetchAllFromWhere(string $tableName, array $where, string|bool $asObject): bool|array
    {
        return $this->fromWhere($tableName, $where, $asObject)->fetchAll();
    }

    /**
     * @throws \Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException
     */
    public function fromWhere(string $tableName, array $where, string|bool $asObject): Select
    {
        $fluent = $this->getFluentPdoBuilder();
        return $fluent->from($tableName)->where($where)->asObject($asObject);
    }

    /**
     * @throws \Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException
     */
    public function insertEntity(Entity $entity, array $attributes): bool|int
    {
        $values = [];

        foreach ($attributes as $attribute)
        {
            $values[$attribute] = $entity->{$attribute};
        }

        $fluent = $this->getFluentPdoBuilder();
        return $fluent->insertInto($entity::getTableName(), $values)->execute();
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function rollback()
    {
        $this->pdo->rollBack();
    }
}