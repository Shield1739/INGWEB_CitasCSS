<?php

namespace Shield1739\UTP\CitasCss\app\entities;

use JetBrains\PhpStorm\Pure;

class PacienteEntity extends CuentaEntity
{
    public const CUENTA = 1;
    public const CITA_PACIENTE_INFO = 2;

    public ?int $pacienteID;
    public ?int $pacienteCuentaID;
    public ?string $pacienteNSS;
    public ?string $pacienteNumeroContacto;
    public ?string $pacienteFechaNacimiento;

    #[Pure] public function __construct()
    {
        parent::__construct();

        $this->cuentaTipoID = self::TIPO_CUENTA_PACIENTE;
        $this->pacienteID = null;
        $this->pacienteCuentaID = null;
        $this->pacienteNSS = null;
        $this->pacienteNumeroContacto = null;
        $this->pacienteFechaNacimiento = null;
    }

    public static function getTableName(): string
    {
        return 'paciente';
    }

    public static function getPrimaryKey(): string
    {
        return 'pacienteID';
    }

    public static function getJoin($key): string
    {
        $joins = [
            self::CUENTA => 'cuenta ON cuentaID = pacienteCuentaID',
            self::CITA_PACIENTE_INFO => 'cita ON citaPacienteID = pacienteID'
        ];

        return $joins[$key] ?? '';
    }
}