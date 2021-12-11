<?php

namespace Shield1739\UTP\CitasCss\app\entities;

use JetBrains\PhpStorm\Pure;

class CitaExtendedEntity extends CitaEntity
{
    public ?string $horaInicio;
    public ?string $bloqueHoraHoraInicio;
    public ?int $clinicaID;
    public ?string $clinicaNombre;
    public ?string $clinicaDireccion;
    public ?string $doctorCuentaNombre;
    public ?string $doctorCuentaApellido;
    public ?string $pacienteCuentaNombre;
    public ?string $pacienteCuentaApellido;
    public ?string $citaPacienteInfoNombre;
    public ?string $citaPacienteInfoApellido;

    #[Pure] public function __construct()
    {
        parent::__construct();

        $this->horaInicio = null;
        $this->bloqueHoraHoraInicio = null;
        $this->clinicaID = null;
        $this->clinicaNombre = null;
        $this->clinicaDireccion = null;
        $this->doctorCuentaNombre = null;
        $this->doctorCuentaApellido = null;
        $this->pacienteCuentaNombre = null;
        $this->pacienteCuentaApellido = null;
        $this->citaPacienteInfoNombre = null;
        $this->citaPacienteInfoApellido = null;
    }

    public function getDoctorFullName(): string
    {
        return $this->doctorCuentaNombre . ' ' . $this->doctorCuentaApellido;
    }

    public function getPacienteFullName(): string
    {
        if ($this->citaPacienteID)
        {
            return $this->pacienteCuentaNombre . ' ' . $this->pacienteCuentaApellido;
        }
        else
        {
            return $this->citaPacienteInfoNombre . ' ' . $this->citaPacienteInfoApellido;
        }
    }

    public static function getJoin($key): string
    {
        $joins = [
            self::PACIENTE => 'paciente ON pacienteID = citaPacienteID',
            self::CITA_PACIENTE_INFO => 'citaPacienteInfo ON citaPacienteInfoID = citaID',
            self::BLOQUE_HORA => 'bloquehora ON bloqueHoraID = citaBloqueHoraID'
        ];

        return $joins[$key] ?? '';
    }
}