<?php

namespace Shield1739\UTP\CitasCss\app\entities;

use JetBrains\PhpStorm\Pure;

class DoctorEntity extends CuentaEntity
{
    public const CUENTA = 1;
    public const CITA = 2;
    public const CLINICA = 3;
    public const DOCTOR_ESPECIALIDAD = 4;

    public ?int $doctorID;
    public ?int $doctorCuentaID;
    public ?int $doctorClinicaID;

    #[Pure] public function __construct()
    {
        parent::__construct();
        $this->cuentaTipoID = self::TIPO_CUENTA_DOCTOR;
        $this->doctorID = null;
        $this->doctorCuentaID = null;
        $this->doctorClinicaID = null;
    }

    public static function getTableName(): string
    {
        return 'doctor';
    }

    public static function getPrimaryKey(): string
    {
        return 'doctorID';
    }

    public static function getJoin($key): string
    {
        $joins = [
            self::CUENTA => 'cuenta ON cuentaID = doctorCuentaID',
            self::DOCTOR => 'cita ON citaDoctorID = doctorID',
            self::CLINICA => 'clinica ON clinicaID = doctorClinicaID',
            self::DOCTOR_ESPECIALIDAD => 'doctor_especialidad ON doctorEspecialidadDoctorID = doctorID'
        ];

        return $joins[$key] ?? '';
    }
}