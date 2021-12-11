<?php

namespace Shield1739\UTP\CitasCss\app\entities;

use Shield1739\UTP\CitasCss\core\common\Entity;

class EspecialidadEntity extends Entity
{
    public const DOCTOR_ESPECIALIDAD = 1;
    public const DOCTOR_ESPECIALIDAD_DOCTOR = 2;

    public ?int $especialidadID;
    public ?string $especialidadNombre;

    public function __construct()
    {
        $this->especialidadID = null;
        $this->especialidadNombre = null;
    }

    public static function getTableName(): string
    {
        return 'especialidad';
    }

    public static function getPrimaryKey(): string
    {
        return 'especialidadID';
    }

    public static function getJoin($key): string
    {
        $joins = [
            self::DOCTOR_ESPECIALIDAD => 'doctor_especialidad ON doctorEspecialidadEspecialidadID = especialidadID',
            self::DOCTOR_ESPECIALIDAD_DOCTOR => 'doctor ON doctorEspecialidadDoctorID = doctorID'
        ];

        return $joins[$key] ?? '';
    }

}