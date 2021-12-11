<?php

namespace Shield1739\UTP\CitasCss\app\backend\models\admin;

use Shield1739\UTP\CitasCss\app\entities\ClinicaEntity;
use Shield1739\UTP\CitasCss\app\entities\DoctorEntity;
use Shield1739\UTP\CitasCss\app\entities\EspecialidadEntity;
use Shield1739\UTP\CitasCss\core\common\Model;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class AdminDashboardAjaxModel extends Model
{

    public function init()
    {

    }

    public function fetchDoctorClinica($doctorID)
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            return $fluent
                ->from(DoctorEntity::getTableName())
                ->asObject(ClinicaEntity::class)
                ->select('clinica.*', true)
                ->innerJoin(DoctorEntity::getJoin(DoctorEntity::CLINICA))
                ->where(DoctorEntity::getPrimaryKey(), $doctorID)
                ->fetch();
        }
        catch (FluentPdoException $e)
        {
            return null;
        }
    }

    public function fetchDoctorEspecialidades(mixed $doctorID)
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            return $fluent
                ->from(EspecialidadEntity::getTableName())
                ->asObject(EspecialidadEntity::class)
                ->innerJoin(EspecialidadEntity::getJoin(EspecialidadEntity::DOCTOR_ESPECIALIDAD))
                ->where('doctorEspecialidadDoctorID', $doctorID)
                ->fetchAll();
        }
        catch (FluentPdoException $e)
        {
            return null;
        }
    }

    public function getAllAttributes(): array
    {
        return [];
    }

    public function getRules(): array
    {
        return [];
    }
}