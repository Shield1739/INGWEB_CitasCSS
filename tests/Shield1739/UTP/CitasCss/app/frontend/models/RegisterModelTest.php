<?php

namespace Shield1739\UTP\CitasCss\app\frontend\models;

use Shield1739\UTP\CitasCss\app\entities\CuentaEntity;
use Shield1739\UTP\CitasCss\app\frontend\models\RegisterModel;
use Shield1739\UTP\CitasCss\tests\AppTestCase;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertIsObject;

class RegisterModelTest extends AppTestCase
{
    protected RegisterModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new RegisterModel();
        $this->model->getPdoUtils()->beginTransaction();;
    }

    public function testRegister()
    {
        $cedula = '321-456-789';
        $correo = 'aaaa@bbb.ccc';

        $cuentaByCedula = $this->model->getPdoUtils()->fetchFromWhere('cuenta', ['cuentaCedula' => $cedula], CuentaEntity::class);
        $cuentaByCorreo = $this->model->getPdoUtils()->fetchFromWhere('cuenta', ['cuentaCorreo' => $correo], CuentaEntity::class);

        assertFalse($cuentaByCedula);
        assertFalse($cuentaByCorreo);

        $this->model->contrasena = 'aa';

        $this->model->cuenta->cuentaCorreo = $correo;
        $this->model->cuenta->cuentaCedula = $cedula;
        $this->model->cuenta->cuentaNombre = 'aasdas';
        $this->model->cuenta->cuentaApellido = 'lhmjlhmj';

        $this->model->paciente->pacienteNSS = '21312';
        $this->model->paciente->pacienteNumeroContacto = '123123123';
        $this->model->paciente->pacienteFechaNacimiento = '2020/01/01';

        $this->model->register();

        $cuentaByCedula = $this->model->getPdoUtils()->fetchFromWhere('cuenta', ['cuentaCedula' => $cedula], CuentaEntity::class);
        $cuentaByCorreo = $this->model->getPdoUtils()->fetchFromWhere('cuenta', ['cuentaCorreo' => $correo], CuentaEntity::class);

        assertIsObject($cuentaByCedula);
        assertIsObject($cuentaByCorreo);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->model->getPdoUtils()->rollback();
    }

}
