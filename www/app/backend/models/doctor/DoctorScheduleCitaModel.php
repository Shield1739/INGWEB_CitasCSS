<?php

namespace Shield1739\UTP\CitasCss\app\backend\models\doctor;

use Shield1739\UTP\CitasCss\app\entities\BloqueHoraEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaPacienteInfoEntity;
use Shield1739\UTP\CitasCss\app\entities\PacienteEntity;
use Shield1739\UTP\CitasCss\core\common\Model;
use Shield1739\UTP\CitasCss\core\Utilities;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class DoctorScheduleCitaModel extends Model
{
    public CitaEntity $cita;
    public CitaPacienteInfoEntity $citaPacienteInfo;

    public ?string $doctorID;
    public ?string $fecha;
    public ?string $bloqueHoraID;
    public ?string $motivo;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->cita = new CitaEntity();
        $this->citaPacienteInfo = new CitaPacienteInfoEntity();
        $this->doctorID = null;
        $this->fecha = null;
        $this->bloqueHoraID = null;
        $this->motivo = null;
    }

    public function loadData($data)
    {
        parent::loadData($data);

        if(!strtotime($this->fecha))
        {
            $this->fecha = null;
        }

        if (!ctype_digit($this->bloqueHoraID))
        {
            $this->bloqueHoraID = null;
        }
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

    public function insertCita()
    {

        $this->cita->citaEstadoID = $this->cita::ESTADO_CITA_AGENDADA;
        $this->cita->citaDoctorID = $this->doctorID;
        $this->cita->citaFecha = $this->fecha;
        $this->cita->citaBloqueHoraID = $this->bloqueHoraID;
        $this->cita->citaMotivo = $this->motivo;
        $this->cita->citaCodigoSeguimineto = $this->getUniqueCodigoSeguimiento();

        try
        {
            $citaID = $this->pdoUtils->insertEntity($this->cita, $this->getEntityAttributes('cita'));
            $this->citaPacienteInfo->citaPacienteInfoID = $citaID;
            $this->pdoUtils->insertEntity($this->citaPacienteInfo, $this->getEntityAttributes('citaPacienteInfo'));
        }
        catch (FluentPdoException $e)
        {
        }
    }

    public function getUniqueCodigoSeguimiento(): string
    {
        $uniqueCode = '';
        try
        {
            $fluent = $this->pdoUtils->getFluentPdoBuilder();
            $valid = true;
            while ($valid)
            {
                $uniqueCode = Utilities::random_str(6, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
                $valid = $fluent
                    ->from(CitaEntity::getTableName())
                    ->select('citaCodigoSeguimineto')
                    ->where('citaCodigoSeguimineto', $uniqueCode)
                    ->fetch();
            }
        }
        catch (\Exception $e)
        {
        }

        return $uniqueCode;
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
                'doctorID',
                'fecha',
                'bloqueHoraID',
                'motivo'
            ],
            'cita' => [
                'citaEstadoID',
                'citaDoctorID',
                'citaPacienteID',
                'citaBloqueHoraID',
                'citaCodigoSeguimineto',
                'citaFecha',
                'citaMotivo'
            ],
            'citaPacienteInfo' => [
                'citaPacienteInfoID',
                'citaPacienteInfoCorreo',
                'citaPacienteInfoCedula',
                'citaPacienteInfoNSS',
                'citaPacienteInfoNombre',
                'citaPacienteInfoApellido',
                'citaPacienteInfoNumeroContacto'
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
                'doctorID' => [self::RULE_REQUIRED],
                'fecha' => [self::RULE_REQUIRED, self::RULE_WORK_DAY],
                'bloqueHoraID' => [self::RULE_REQUIRED],
                'motivo' => [[self::RULE_MAX, 'max' => 50]],
            ],
            'cita' => [

            ],
            'citaPacienteInfo' => [
                'citaPacienteInfoCorreo' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_MAX, 'max' => 255]],
                'citaPacienteInfoCedula' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 30], self::RULE_CEDULA],
                'citaPacienteInfoNombre' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 40]],
                'citaPacienteInfoApellido' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 40]],
                'citaPacienteInfoNSS' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 30]],
                'citaPacienteInfoNumeroContacto' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 20]]
            ],
        ];
    }
}