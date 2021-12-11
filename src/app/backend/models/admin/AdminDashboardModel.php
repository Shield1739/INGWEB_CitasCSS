<?php

namespace Shield1739\UTP\CitasCss\app\backend\models\admin;

use phpDocumentor\Reflection\Types\This;
use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\app\entities\ClinicaEntity;
use Shield1739\UTP\CitasCss\app\entities\DoctorEntity;
use Shield1739\UTP\CitasCss\app\entities\EspecialidadEntity;
use Shield1739\UTP\CitasCss\app\entities\PacienteEntity;
use Shield1739\UTP\CitasCss\core\common\Model;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class AdminDashboardModel extends Model
{
    public ?int $pacienteCount;
    public ?int $doctoresCount;
    public ?int $citasCount;
    public ?int $citasAgendadasCount;
    public ?int $citasCanceladasCount;
    public ?int $citasTerminadasCount;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->pacienteCount = null;
        $this->doctoresCount = null;
        $this->citasCount = null;
        $this->citasAgendadasCount = null;
        $this->citasCanceladasCount = null;
        $this->citasTerminadasCount = null;
    }

    public function loadCounts()
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            $this->pacienteCount = $fluent->from(PacienteEntity::getTableName())->count();
            $this->doctoresCount = $fluent->from(DoctorEntity::getTableName())->count();
            $this->citasAgendadasCount = $fluent->from(CitaEntity::getTableName())->where('citaEstadoID', 1)->count();
            $this->citasCanceladasCount = $fluent->from(CitaEntity::getTableName())->where('citaEstadoID', 3)->count();
            $this->citasTerminadasCount = $fluent->from(CitaEntity::getTableName())->where('citaEstadoID', 2)->count();
            $this->citasCount = $this->citasAgendadasCount + $this->citasCanceladasCount + $this->citasTerminadasCount;
        }
        catch (FluentPdoException $e)
        {

        }

    }

    public function fetchAllClinicas(): bool|array
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            return $fluent->from(ClinicaEntity::getTableName())->asObject(ClinicaEntity::class)->fetchAll();
        }
        catch (FluentPdoException $e)
        {
            return [];
        }
    }

    public function fetchAllEspecialidades(): bool|array
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            return $fluent->from(EspecialidadEntity::getTableName())->asObject(EspecialidadEntity::class)->fetchAll();
        }
        catch (FluentPdoException $e)
        {
            return [];
        }
    }

    public function fetchAllDoctores(): bool|array
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            return $fluent
                ->from(DoctorEntity::getTableName())
                ->asObject(DoctorEntity::class)
                ->select('cuenta.*')
                ->innerJoin(DoctorEntity::getJoin(DoctorEntity::CUENTA))
                ->fetchAll();
        }
        catch (FluentPdoException $e)
        {
            return [];
        }
    }

    // Clinicas

    public function insertClinica(string $clinicaNombre, string $clinicaDireccion): bool
    {
        $clinica = new ClinicaEntity();

        $clinica->clinicaNombre = $clinicaNombre;
        $clinica->clinicaDireccion = $clinicaDireccion;

        $attributes = ['clinicaNombre', 'clinicaDireccion'];

        try
        {
            $this->pdoUtils->insertEntity($clinica, $attributes);
            return true;
        }
        catch (FluentPdoException $e)
        {
            return false;
        }
    }

    public function editClinica(string $clinicaID, string $clinicaNombre, string $clinicaDireccion): bool
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        $set = [
          'clinicaNombre' => $clinicaNombre,
          'clinicaDireccion' => $clinicaDireccion
        ];
        try
        {
            $fluent->update(ClinicaEntity::getTableName())->set($set)->where(ClinicaEntity::getPrimaryKey(), $clinicaID)->execute();
            return true;
        }
        catch (FluentPdoException $e)
        {
            return false;
        }
    }

    public function deleteClinica(string $clinicaID): bool
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            $fluent->delete(ClinicaEntity::getTableName())->where(ClinicaEntity::getPrimaryKey(), $clinicaID)->execute();
            return true;
        }
        catch (FluentPdoException $e)
        {
            var_dump($e);
            return false;
        }
    }

    // Especialidad

    public function insertEspecialidad(string $especialidadNombre): bool
    {
        $especialidad = new EspecialidadEntity();

        $especialidad->especialidadNombre = $especialidadNombre;

        $attributes = ['especialidadNombre'];

        try
        {
            $this->pdoUtils->insertEntity($especialidad, $attributes);
            return true;
        }
        catch (FluentPdoException $e)
        {
            return false;
        }
    }

    public function editEspecialidad(string $especialidadID, string $especialidadNombre): bool
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        $set = [
            'especialidadNombre' => $especialidadNombre
        ];
        try
        {
            $fluent->update(EspecialidadEntity::getTableName())->set($set)->where(EspecialidadEntity::getPrimaryKey(), $especialidadID)->execute();
            return true;
        }
        catch (FluentPdoException $e)
        {
            return false;
        }
    }

    public function deleteEspecialidad(string $especialidadID): bool
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            $fluent->delete(EspecialidadEntity::getTableName())->where(EspecialidadEntity::getPrimaryKey(), $especialidadID)->execute();
            return true;
        }
        catch (FluentPdoException $e)
        {
            var_dump($e);
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAllAttributes(): array
    {
        return [
            self::MODEL_KEY => [
                'pacienteCount',
                'doctoresCount',
                'citasCount',
                'citasAgendadasCount',
                'citasCanceladasCount',
                'citasTerminadasCount'
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function getRules(): array
    {
        return [];
    }
}