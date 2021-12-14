<?php

namespace Shield1739\UTP\CitasCss\app;

use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\app\entities\CuentaEntity;
use Shield1739\UTP\CitasCss\app\entities\DoctorEntity;
use Shield1739\UTP\CitasCss\tests\AppTestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertIsObject;
use function PHPUnit\Framework\assertNull;

class PDOUtilsTest extends AppTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->pdoUtils = new PDOUtils();
        $this->pdoUtils->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->pdoUtils->rollback();
    }

    public function testFetchPkWhere()
    {
        assertEquals(1, $this->pdoUtils->fetchPkWhere(CuentaEntity::class, ['cuentaID' => 1]));
        assertEquals(2, $this->pdoUtils->fetchPkWhere(DoctorEntity::class, ['doctorID' => 2]));
        assertEquals(3, $this->pdoUtils->fetchPkWhere(DoctorEntity::class, ['doctorID = ?' => 3]));

        assertEquals(false, $this->pdoUtils->fetchPkWhere(CuentaEntity::class, ['cuentaID' => 0]));
        assertEquals(false, $this->pdoUtils->fetchPkWhere(CuentaEntity::class, ['cuentaID = ?' => 500]));

        assertEquals(22, $this->pdoUtils->fetchPkWhere(CuentaEntity::class, ['cuentaCorreo' => 'doctor19@sa.a']));
    }

    public function testFetchPacienteEmailFromCita()
    {
        assertEquals('luis.villalaz1@utp.ac.pa', $this->pdoUtils->fetchPacienteEmailFromCita(1));
        assertEquals('paciente2@sa.a', $this->pdoUtils->fetchPacienteEmailFromCita(2));
        assertEquals(false, $this->pdoUtils->fetchPacienteEmailFromCita(0));
    }

    public function testFetchCodigoSeguimientoFromCitaID()
    {
        assertEquals('ABCDFG', $this->pdoUtils->fetchCodigoSeguimientoFromCitaID(1));
        assertEquals('AABBCC', $this->pdoUtils->fetchCodigoSeguimientoFromCitaID(2));
        assertEquals('CCDDFF', $this->pdoUtils->fetchCodigoSeguimientoFromCitaID(8));
        assertEquals(false, $this->pdoUtils->fetchCodigoSeguimientoFromCitaID(0));
    }

    public function testGetAllCitaExtendedForPaciente()
    {
        assertCount(6, $this->pdoUtils->getAllCitaExtendedForPaciente(['citaPacienteID' => 1]));
        assertCount(3, $this->pdoUtils->getAllCitaExtendedForPaciente(['citaPacienteID' => 2]));
        assertCount(0, $this->pdoUtils->getAllCitaExtendedForPaciente(['citaPacienteID' => 500]));

        $citas1 = $this->pdoUtils->getAllCitaExtendedForPaciente(['citaPacienteID' => 3, 'citaCodigoSeguimineto' => 'AAABBB']);
        assertCount(1, $citas1);
        assertEquals(1, $citas1[0]->citaDoctorID);
        assertEquals('Manuel', $citas1[0]->doctorCuentaNombre);
        assertEquals(3, $citas1[0]->citaBloqueHoraID);
        assertEquals('09:00 AM', $citas1[0]->horaInicio);
        assertEquals(1, $citas1[0]->clinicaID);
        assertEquals('Policlínica Especializada de la CSS', $citas1[0]->clinicaNombre);

        $citas2 = $this->pdoUtils->getAllCitaExtendedForPaciente(['citaCodigoSeguimineto' => 'ADADCF']);
        assertCount(1, $citas2);
        assertEquals(2, $citas2[0]->citaDoctorID);
        assertEquals('Patrick', $citas2[0]->doctorCuentaApellido);
        assertEquals(1, $citas2[0]->citaBloqueHoraID);
        assertEquals('08:00 AM', $citas2[0]->horaInicio);
        assertEquals(1, $citas2[0]->clinicaID);
        assertEquals('Policlínica Especializada de la CSS', $citas2[0]->clinicaNombre);
    }

    public function testGetAllCitaExtendedForDoctor()
    {
        assertCount(7, $this->pdoUtils->getAllCitaExtendedForDoctor(['citaDoctorID' => 1]));
        assertCount(4, $this->pdoUtils->getAllCitaExtendedForDoctor(['citaDoctorID' => 2]));
        assertCount(0, $this->pdoUtils->getAllCitaExtendedForDoctor(['citaDoctorID' => 40]));

        $citas1 = $this->pdoUtils->getAllCitaExtendedForDoctor(['citaCodigoSeguimineto' => 'AAABBB']);
        assertCount(1, $citas1);
        assertEquals(3, $citas1[0]->citaPacienteID);
        assertEquals('NombreP3', $citas1[0]->pacienteCuentaNombre);
        assertNull($citas1[0]->citaPacienteInfoNombre);
        assertEquals(3, $citas1[0]->citaBloqueHoraID);
        assertEquals('09:00 AM', $citas1[0]->horaInicio);
        assertEquals(1, $citas1[0]->clinicaID);
        assertEquals('Policlínica Especializada de la CSS', $citas1[0]->clinicaNombre);
    }

    public function testFetchAllAvailableHoras()
    {
        assertCount(14, $this->pdoUtils->fetchAllAvailableHoras(1, '2020/01/01'));

        $horas1 = $this->pdoUtils->fetchAllAvailableHoras(1, '2021/12/13');
        assertCount(8, $horas1);
        assertEquals(5, $horas1[0]->bloqueHoraID);
        assertEquals(10, $horas1[3]->bloqueHoraID);

        $horas2 = $this->pdoUtils->fetchAllAvailableHoras(2, '2021/12/13');
        assertCount(12, $horas2);
        assertEquals(2, $horas2[0]->bloqueHoraID);

        $horas3 = $this->pdoUtils->fetchAllAvailableHoras(3, '2021/12/13');
        assertCount(14, $horas3);

    }

    public function testFetchPacienteIdFromCuentaId()
    {
        assertEquals(1, $this->pdoUtils->fetchPacienteIdFromCuentaId(2));
        assertEquals(2, $this->pdoUtils->fetchPacienteIdFromCuentaId(3));
        assertEquals(3, $this->pdoUtils->fetchPacienteIdFromCuentaId(4));
        assertEquals(false, $this->pdoUtils->fetchPacienteIdFromCuentaId(0));
    }

    public function testFetchDoctorIdFromCuentaId()
    {
        assertEquals(4, $this->pdoUtils->fetchDoctorIdFromCuentaId(8));
        assertEquals(5, $this->pdoUtils->fetchDoctorIdFromCuentaId(9));
        assertEquals(6, $this->pdoUtils->fetchDoctorIdFromCuentaId(10));
        assertEquals(false, $this->pdoUtils->fetchDoctorIdFromCuentaId(0));
    }

    public function testCancelCita()
    {
        $cita = $this->pdoUtils->fetchFromWhere('cita', ['citaCodigoSeguimineto' => 'CLJHJD'], CitaEntity::class);
        assertIsObject($cita);
        assertEquals(1, $cita->citaEstadoID);

        $this->pdoUtils->cancelCita($cita->citaID);

        $citaCancelada = $this->pdoUtils->fetchFromWhere('cita', ['citaCodigoSeguimineto' => 'CLJHJD'], CitaEntity::class);
        assertIsObject($citaCancelada);
        assertEquals(3, $citaCancelada->citaEstadoID);
    }

    public function testRescheduleCita()
    {
        $cita = $this->pdoUtils->fetchFromWhere('cita', ['citaCodigoSeguimineto' => 'CLKHJD'], CitaEntity::class);
        assertIsObject($cita);
        assertEquals(4, $cita->citaBloqueHoraID);
        assertEquals('2021-12-20', $cita->citaFecha);

        $this->pdoUtils->rescheduleCita($cita->citaID, '2021/12/21', 1);

        $citaReprogramada = $this->pdoUtils->fetchFromWhere('cita', ['citaCodigoSeguimineto' => 'CLKHJD'], CitaEntity::class);
        assertIsObject($citaReprogramada);
        assertEquals(1, $citaReprogramada->citaBloqueHoraID);
        assertEquals('2021-12-21', $citaReprogramada->citaFecha);
    }
}