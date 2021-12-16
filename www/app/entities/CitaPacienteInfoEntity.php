<?php

namespace Shield1739\UTP\CitasCss\app\entities;

use Shield1739\UTP\CitasCss\core\common\Entity;

class CitaPacienteInfoEntity extends Entity
{
    public const CITA = 1;

    public ?int $citaPacienteInfoID;
    public ?string $citaPacienteInfoCorreo;
    public ?string $citaPacienteInfoCedula;
    public ?string $citaPacienteInfoNSS;
    public ?string $citaPacienteInfoNombre;
    public ?string $citaPacienteInfoApellido;
    public ?string $citaPacienteInfoNumeroContacto;

    public function __construct()
    {
        $this->citaPacienteInfoID = null;
        $this->citaPacienteInfoCorreo = null;
        $this->citaPacienteInfoCedula = null;
        $this->citaPacienteInfoNSS = null;
        $this->citaPacienteInfoNombre = null;
        $this->citaPacienteInfoApellido = null;
        $this->citaPacienteInfoNumeroContacto = null;
    }

    public static function getTableName(): string
    {
        return 'citapacienteinfo';
    }

    public static function getPrimaryKey(): string
    {
        return 'citaPacienteInfoID';
    }

    public static function getJoin($key): string
    {
        $joins = [
            self::CITA => 'cita ON citaID = citaPacienteInfoID'
        ];

        return $joins[$key] ?? '';
    }
}