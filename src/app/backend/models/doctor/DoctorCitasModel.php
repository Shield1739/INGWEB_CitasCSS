<?php

namespace Shield1739\UTP\CitasCss\app\backend\models\doctor;

use Shield1739\UTP\CitasCss\app\entities\BloqueHoraEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaExtendedEntity;
use Shield1739\UTP\CitasCss\app\entities\PacienteEntity;
use Shield1739\UTP\CitasCss\core\common\Model;
use Shield1739\UTP\CitasCss\core\Utilities;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class DoctorCitasModel extends Model
{
    /** @var CitaExtendedEntity[] */
    public ?array $citas;

    public ?string $citaID;

    public ?string $doctorID;
    public ?string $fecha;
    public ?string $bloqueHoraID;

    public ?string $weekStart;
    public ?string $weekEnd;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->citas = [];
        $this->citaID = null;
        $this->doctorID = null;
        $this->fecha = null;
        $this->bloqueHoraID = null;
        $this->weekStart = null;
        $this->weekEnd = null;
    }

    public function loadData($data)
    {
        parent::loadData($data);

        if (!strtotime($this->fecha))
        {
            $this->fecha = null;
        }

        if (!ctype_digit($this->bloqueHoraID))
        {
            $this->bloqueHoraID = null;
        }
    }

    public function loadCitas(int $cuentaID)
    {
        $doctorID = $this->pdoUtils->fetchDoctorIdFromCuentaId($cuentaID);

        $this->citas = $this->pdoUtils->getAllCitaExtendedForDoctor(
            [
                'citaFecha >= ?' => $this->weekStart,
                'citaDoctorID' => $doctorID,
                'citaEstadoID' => CitaEntity::ESTADO_CITA_AGENDADA
            ]);
    }

    public function rescheduleCita(): bool
    {
        //First check if cita is of account
        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            $citaDoctorID = $fluent
                ->from(CitaEntity::getTableName())
                ->asObject(CitaEntity::class)
                ->where(CitaEntity::getPrimaryKey(), $this->citaID)
                ->fetch('citaDoctorID');

        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        if (($citaDoctorID && (int)$this->doctorID) && ($citaDoctorID === (int)$this->doctorID))
        {
            return $this->pdoUtils->rescheduleCita($this->citaID, $this->fecha, $this->bloqueHoraID);
        }

        return false;
    }

    public function cancelCita(): bool
    {
        //First check if cita is of account
        $fluent = $this->pdoUtils->getFluentPdoBuilder();
        try
        {
            $citaDoctorID = $fluent
                ->from(CitaEntity::getTableName())
                ->asObject(CitaEntity::class)
                ->where(CitaEntity::getPrimaryKey(), $this->citaID)
                ->fetch('citaDoctorID');

        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        if (($citaDoctorID && (int)$this->doctorID) && ($citaDoctorID === (int)$this->doctorID))
        {
            return $this->pdoUtils->cancelCita($this->citaID);
        }

        return false;
    }

    public function getAllHorasOptions(): array
    {
        if (is_null($this->fecha) || is_null($this->doctorID))
        {
            return [];
        }

        $horas = $this->pdoUtils->fetchAllAvailableHoras($this->doctorID, $this->fecha);

        $options = [];
        /** @var BloqueHoraEntity $hora */
        foreach ($horas as $hora)
        {
            $options[$hora->bloqueHoraID] = $hora->bloqueHoraHoraInicio;
        }
        return $options;
    }

    public function loadWeekRange(string $datestr)
    {
        $weekRange = Utilities::rangeWorkWeek($datestr);
        $this->weekStart = $weekRange['start'];
        $this->weekEnd = $weekRange['end'];
    }

    public function setDoctorID(string $cuentaID)
    {
        $this->doctorID = $this->pdoUtils->fetchDoctorIdFromCuentaId($cuentaID);
    }

    /**
     * @inheritDoc
     */
    public function getAllAttributes(): array
    {
        return [
            self::MODEL_KEY => [
                'citaID',
                'fecha',
                'bloqueHoraID'
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
                'citaID' => [self::RULE_REQUIRED],
                'fecha' => [self::RULE_REQUIRED, self::RULE_WORK_DAY],
                'bloqueHoraID' => [self::RULE_REQUIRED]
            ]
        ];
    }
}