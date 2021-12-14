<?php

namespace Shield1739\UTP\CitasCss\app\frontend\models\cita;

use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\tests\AppTestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertIsObject;

class ScheduleCitaModelTest extends AppTestCase
{
    private ScheduleCitaModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new ScheduleCitaModel();
    }

    /**
     * @dataProvider loadRegisteredPacienteDataDataProvider
     */
    public function testLoadRegisteredPacienteData($expectedCedula, $cuentaID)
    {
        $this->model->loadRegisteredPacienteData($cuentaID);
        assertEquals($expectedCedula, $this->model->citaPacienteInfo->citaPacienteInfoCedula);
    }

    public function loadRegisteredPacienteDataDataProvider()
    {
        return [
            ['1-1-1', 2],
            ['1-1-2', 3],
            ['1-1-3', 4]
        ];
    }

    public function testGetAllClinicasOptions()
    {
        $clinicas = $this->model->getAllClinicasOptions();
        assertCount(5, $clinicas);
        assertEquals('Policlínica Especializada de la CSS', $clinicas[1][0]);
        assertEquals('Policlínica de la CSS Dr. Carlos N. Brin', $clinicas[5][0]);
    }

    public function testGetAllEspecialidadesOptions()
    {
        $this->model->clinicaID = 1;
        $especialidades = $this->model->getAllEspecialidadesOptions();
        assertCount(5, $especialidades);
        assertEquals('Ortopedia', $especialidades[1]);
        assertEquals('Hematología', $especialidades[5]);
    }

    public function testGetAllDoctoresOptions()
    {
        $this->model->clinicaID = 1;
        $this->model->especialidadID = 1;
        $doctores = $this->model->getAllDoctoresOptions();
        assertCount(2, $doctores);
        assertEquals('Manuel Osas', $doctores[1]);
        assertEquals('Vanessa Patrick', $doctores[2]);
    }

    public function testGetAllHorasOptions()
    {
        $this->model->fecha = '2021/12/13';
        $this->model->doctorID = 1;
        $horas = $this->model->getAllHorasOptions();
        assertCount(8, $horas);
    }

    public function testInsertCita()
    {
        $this->model->getPdoUtils()->beginTransaction();

        $cita = $this->model->getPdoUtils()->fetchFromWhere('cita', ['citaFecha' => '2021/12/18'], CitaEntity::class);
        assertFalse($cita);

        $this->model->doctorID = 1;
        $this->model->fecha = '2021/12/18';
        $this->model->bloqueHoraID = 1;
        $this->model->motivo = 'abc';
        $this->model->citaPacienteInfo->citaPacienteInfoCorreo = '';

        $this->model->insertCita(2);

        $cita = $this->model->getPdoUtils()->fetchFromWhere('cita', ['citaFecha' => '2021/12/18'], CitaEntity::class);
        assertIsObject($cita);

        $this->model->getPdoUtils()->rollback();
    }
}
