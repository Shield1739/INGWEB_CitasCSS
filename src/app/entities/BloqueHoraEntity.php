<?php

namespace Shield1739\UTP\CitasCss\app\entities;

use Shield1739\UTP\CitasCss\core\common\Entity;

class BloqueHoraEntity extends Entity
{
    public const BLOQUE_HORA = 1;

    public ?int $bloqueHoraID;
    public ?string $bloqueHoraHoraInicio;

    public function __construct()
    {
        $this->bloqueHoraID = null;
        $this->bloqueHoraHoraInicio = null;
    }

    public static function getTableName(): string
    {
        return 'bloquehora';
    }

    public static function getPrimaryKey(): string
    {
        return 'bloqueHoraID';
    }

    public static function getJoin($key): string
    {
        $joins = [
            self::BLOQUE_HORA => 'cita ON citaBloqueHoraID = bloqueHoraID'
        ];

        return $joins[$key] ?? '';
    }

    public static function getHoraInicioFormatKey()
    {
        return "TIME_FORMAT(bloqueHoraHoraInicio, '%h\:%i %p')";
    }
}