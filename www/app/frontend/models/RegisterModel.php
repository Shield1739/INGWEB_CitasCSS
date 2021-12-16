<?php

namespace Shield1739\UTP\CitasCss\app\frontend\models;

use Shield1739\UTP\CitasCss\app\entities\CuentaEntity;
use Shield1739\UTP\CitasCss\app\entities\PacienteEntity;
use Shield1739\UTP\CitasCss\core\common\Model;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class RegisterModel extends Model
{
    public CuentaEntity $cuenta;
    public PacienteEntity $paciente;

    public ?string $contrasena;
    public ?string $confirmarContrasena;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->cuenta = new CuentaEntity();
        $this->cuenta->cuentaTipoID = $this->cuenta::TIPO_CUENTA_PACIENTE;
        $this->paciente = new PacienteEntity();
        $this->contrasena = null;
        $this->confirmarContrasena = null;
    }

    public function register(): bool
    {
        $this->cuenta->cuentaContrasenaHash = password_hash($this->contrasena, PASSWORD_BCRYPT);
        try
        {
            $cuentaID = $this->pdoUtils->insertEntity($this->cuenta, $this->getEntityAttributes('cuenta'));

            if ($cuentaID)
            {
                $this->paciente->pacienteCuentaID = $cuentaID;
                $pacienteID = $this->pdoUtils->insertEntity($this->paciente, $this->getEntityAttributes('paciente'));

                return !is_null($pacienteID);
            }
        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getAllAttributes(): array
    {
        return [
            self::MODEL_KEY => [
                'contrasena',
                'confirmarContrasena'
            ],
            'cuenta' => [
                'cuentaTipoID',
                'cuentaCorreo',
                'cuentaCedula',
                'cuentaContrasenaHash',
                'cuentaNombre',
                'cuentaApellido'
            ],
            'paciente' => [
                'pacienteCuentaID',
                'pacienteNSS',
                'pacienteNumeroContacto',
                'pacienteFechaNacimiento'
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function getRules(): array
    {
        return [
            self::MODEL_KEY => [
                'contrasena' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 2], [self::RULE_MAX, 'max' => 8]],
                'confirmarContrasena' => [self::RULE_REQUIRED, [self::RULE_PASSWORD_MATCH, 'passwordField' => 'contrasena']]
            ],
            'cuenta' => [
                'cuentaCorreo' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_MAX, 'max' => 255],
                    [self::RULE_UNIQUE, 'tableName' => CuentaEntity::getTableName(), 'field' => 'e correo']],
                'cuentaCedula' => [self::RULE_REQUIRED, self::RULE_CEDULA, [self::RULE_MAX, 'max' => 30],
                    [self::RULE_UNIQUE, 'tableName' => CuentaEntity::getTableName(), 'field' => 'a cedula']],
                'cuentaNombre' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 40]],
                'cuentaApellido' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 40]]
            ],
            'paciente' => [
                'pacienteNSS' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 30]],
                'pacienteNumeroContacto' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 20]],
                'pacienteFechaNacimiento' => [self::RULE_REQUIRED]
            ]
        ];
    }
}