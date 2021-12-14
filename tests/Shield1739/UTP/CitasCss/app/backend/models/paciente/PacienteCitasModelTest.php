<?php

namespace Shield1739\UTP\CitasCss\app\backend\models\paciente;

use PHPUnit\Framework\TestCase;
use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\tests\AppTestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class PacienteCitasModelTest extends AppTestCase
{
    private PacienteCitasModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new PacienteCitasModel();
    }


    public function testLoadCitas()
    {
        $this->model->loadCitas(2);
        assertCount(6, $this->model->citas);
    }

    public function testCancelCita()
    {
        $this->model->getPdoUtils()->beginTransaction();

        $cita = $this->model->getPdoUtils()->fetchFromWhere('cita', ['citaCodigoSeguimineto' => 'ABCDFG'], CitaEntity::class);
        assertEquals(1, $cita->citaEstadoID);

        $this->model->citaID = $cita->citaID;
        assertTrue($this->model->cancelCita(2));

        $cita = $this->model->getPdoUtils()->fetchFromWhere('cita', ['citaCodigoSeguimineto' => 'ABCDFG'], CitaEntity::class);
        assertEquals(3, $cita->citaEstadoID);

        $this->model->getPdoUtils()->rollback();

    }

    public function testRescheduleCita()
    {
        $this->model->getPdoUtils()->beginTransaction();

        $cita = $this->model->getPdoUtils()->fetchFromWhere('cita', ['citaCodigoSeguimineto' => 'ABCDFG'], CitaEntity::class);
        assertEquals(1, $cita->citaBloqueHoraID);
        assertEquals('2021-12-13', $cita->citaFecha);

        $this->model->citaID = 1;
        $this->model->fecha = '2021/12/19';
        $this->model->bloqueHoraID = 2;

        assertTrue($this->model->rescheduleCita(2));

        $cita = $this->model->getPdoUtils()->fetchFromWhere('cita', ['citaCodigoSeguimineto' => 'ABCDFG'], CitaEntity::class);
        assertEquals(2, $cita->citaBloqueHoraID);
        assertEquals('2021-12-19', $cita->citaFecha);

        $this->model->getPdoUtils()->rollback();
    }
}
