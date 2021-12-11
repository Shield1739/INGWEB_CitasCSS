<?php

namespace Shield1739\UTP\CitasCss\app\frontend\models;

use Shield1739\UTP\CitasCss\app\entities\CuentaEntity;
use Shield1739\UTP\CitasCss\core\common\Model;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class LoginModel extends Model
{
    public ?CuentaEntity $cuenta;

    public ?string $cedula;
    public ?string $contrasena;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->cedula = null;
        $this->contrasena = null;
    }

    public function login(): bool
    {
        /** @var $cuenta CuentaEntity */
        $cuenta = null;
        try
        {
            $cuenta = $this->pdoUtils->fetchFromWhere(
                CuentaEntity::getTableName(), ['cuentaCedula' => $this->cedula], CuentaEntity::class);
        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        if ($cuenta && password_verify($this->contrasena, $cuenta->cuentaContrasenaHash))
        {
            $this->cuenta = $cuenta;
            return true;
        }

        $this->addError('cedula', '');
        $this->addError('contrasena', 'Ha introducido una cedula o una contraseña incorrecta');
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getAllAttributes(): array
    {
        return [
            self::MODEL_KEY => [
                'cedula',
                'contrasena'
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
                'cedula' => [self::RULE_REQUIRED],
                'contrasena' => [self::RULE_REQUIRED]
            ]
        ];
    }
}