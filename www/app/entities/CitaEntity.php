<?php

namespace Shield1739\UTP\CitasCss\app\entities;

use Shield1739\UTP\CitasCss\core\common\Entity;

class CitaEntity extends Entity
{
    public const PACIENTE = 1;
    public const CITA_PACIENTE_INFO = 2;
    public const BLOQUE_HORA = 3;
    public const DOCTOR = 4;

    public const ESTADO_CITA_AGENDADA = 1;
    public const ESTADO_CITA_TERMINADA = 2;
    public const ESTADO_CITA_CANCELADA = 3;

    public ?int $citaID;
    public ?int $citaEstadoID;
    public ?int $citaDoctorID;
    public ?int $citaPacienteID;
    public ?int $citaBloqueHoraID;
    public ?string $citaCodigoSeguimineto;
    public ?string $citaFecha;
    public ?string $citaMotivo;

    public function __construct()
    {
        $this->citaID = null;
        $this->citaEstadoID = null;
        $this->citaDoctorID = null;
        $this->citaPacienteID = null;
        $this->citaBloqueHoraID = null;
        $this->citaCodigoSeguimineto = null;
        $this->citaFecha = null;
        $this->citaMotivo = null;
    }

    public static function getTableName(): string
    {
        return 'cita';
    }

    public static function getPrimaryKey(): string
    {
        return 'citaID';
    }

    public static function getJoin($key): string
    {
        $joins = [
            self::PACIENTE => 'paciente ON pacienteID = citaPacienteID',
            self::CITA_PACIENTE_INFO => 'citapacienteinfo ON citaPacienteInfoID = citaID',
            self::BLOQUE_HORA => 'bloquehora ON bloqueHoraID = citaBloqueHoraID',
            self::DOCTOR => 'doctor ON doctorID = citaDoctorID'
        ];

        return $joins[$key] ?? '';
    }
}