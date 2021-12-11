<?php

namespace Shield1739\UTP\CitasCss\core\common;

abstract class Entity
{
    abstract public static function getTableName(): string;
    abstract public static function getPrimaryKey(): string;
    abstract public static function getJoin($key): string;

}