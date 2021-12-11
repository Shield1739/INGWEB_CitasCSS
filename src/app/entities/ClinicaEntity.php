<?php

namespace Shield1739\UTP\CitasCss\app\entities;

use Shield1739\UTP\CitasCss\core\common\Entity;

class ClinicaEntity extends Entity
{
    public const DOCTOR = 1;

    public ?int $clinicaID;
    public ?string $clinicaNombre;
    public ?string $clinicaDireccion;

    public function __construct()
    {
        $this->clinicaID = null;
        $this->clinicaNombre = null;
        $this->clinicaDireccion = null;
    }

    public static function getTableName(): string
    {
        return 'clinica';
    }

    public static function getPrimaryKey(): string
    {
        return 'clinicaID';
    }

    public static function getJoin($key): string
    {
        $joins = [
            self::DOCTOR => 'doctor doctorClinicaID ON clinicaID'
        ];

        return $joins[$key] ?? '';
    }

}