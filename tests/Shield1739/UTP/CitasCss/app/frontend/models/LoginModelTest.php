<?php

namespace Shield1739\UTP\CitasCss\app\frontend\models;

use Shield1739\UTP\CitasCss\app\frontend\models\LoginModel;
use Shield1739\UTP\CitasCss\tests\AppTestCase;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class LoginModelTest extends AppTestCase
{
    protected LoginModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new LoginModel();
    }

    public function testLoginNullFields()
    {
        assertFalse($this->model->login());
    }

    public function testLoginWrongCedulaWrongPassword()
    {
        $this->model->cedula = '222-222-22';
        $this->model->contrasena = 'bb';
        assertFalse($this->model->login());
    }

    public function testLoginCorrectCedulaWrongPassword()
    {
        $this->model->cedula = '1-1-1';
        $this->model->contrasena = 'bb';
        assertFalse($this->model->login());
    }

    public function testLoginCorrectCedulaCorrectPassword()
    {
        $this->model->cedula = '1-1-1';
        $this->model->contrasena = 'aa';
        assertTrue($this->model->login());
    }
}
