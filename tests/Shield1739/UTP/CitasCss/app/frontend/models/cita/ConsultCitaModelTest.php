<?php

namespace Shield1739\UTP\CitasCss\app\frontend\models\cita;

use Shield1739\UTP\CitasCss\tests\AppTestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class ConsultCitaModelTest extends AppTestCase
{
    private ConsultCitaModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new ConsultCitaModel();
    }


    public function testLoadCita()
    {
        assertNull($this->model->cita->citaCodigoSeguimineto);
        assertFalse($this->model->validCodigo);

        $this->model->codigoSeguimiento = 'zzzzzz';
        $this->model->loadCita();

        assertNull($this->model->cita->citaCodigoSeguimineto);
        assertFalse($this->model->validCodigo);

        $this->model->codigoSeguimiento = 'BBBCCC';
        $this->model->loadCita();

        assertEquals('BBBCCC', $this->model->cita->citaCodigoSeguimineto);
        assertTrue($this->model->validCodigo);
    }
}
