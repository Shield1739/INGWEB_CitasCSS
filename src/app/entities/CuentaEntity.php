<?php

namespace Shield1739\UTP\CitasCss\app\entities;

use Shield1739\UTP\CitasCss\core\common\Entity;

class CuentaEntity extends Entity
{
    public const PACIENTE = 1;
    public const DOCTOR = 2;

    public const TIPO_CUENTA_ADMIN = 1;
    public const TIPO_CUENTA_PACIENTE = 2;
    public const TIPO_CUENTA_DOCTOR = 3;

    public ?int $cuentaID;
    public ?int $cuentaTipoID;
    public ?string $cuentaCorreo;
    public ?string $cuentaCedula;
    public ?string $cuentaContrasenaHash;
    public ?string $cuentaNombre;
    public ?string $cuentaApellido;
    public ?string $cuentaFechaCreacion;

    public function __construct()
    {
        $this->cuentaID = null;
        $this->cuentaTipoID = null;
        $this->cuentaCorreo = null;
        $this->cuentaCedula = null;
        $this->cuentaContrasenaHash = null;
        $this->cuentaNombre = null;
        $this->cuentaApellido = null;
        $this->cuentaFechaCreacion = null;
    }

    public static function getTableName(): string
    {
        return 'cuenta';
    }

    public static function getPrimaryKey(): string
    {
        return 'cuentaID';
    }

    public static function getJoin($key): string
    {
        $joins = [
            self::PACIENTE => 'paciente ON pacienteCuentaID = cuentaID',
            self::DOCTOR => 'doctor ON doctorCuentaID = cuentaID',
        ];

        return $joins[$key] ?? '';
    }

    public function getFullName(): string
    {
        return $this->cuentaNombre . ' ' . $this->cuentaApellido;
    }

    public function isAdmin(): bool
    {
        return $this->cuentaTipoID === self::TIPO_CUENTA_ADMIN;
    }

    public function isDoctor(): bool
    {
        return $this->cuentaTipoID === self::TIPO_CUENTA_DOCTOR;
    }

    public function isPaciente(): bool
    {
        return $this->cuentaTipoID === self::TIPO_CUENTA_PACIENTE;
    }
}