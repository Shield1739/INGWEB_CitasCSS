<?php

namespace Shield1739\UTP\CitasCss\app\backend\models\paciente;

use Shield1739\UTP\CitasCss\app\entities\BloqueHoraEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaExtendedEntity;
use Shield1739\UTP\CitasCss\app\entities\PacienteEntity;
use Shield1739\UTP\CitasCss\core\common\Model;
use Shield1739\UTP\CitasCss\core\Utilities;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class PacienteCitasModel extends Model
{
    /** @var CitaExtendedEntity[]  */
    public ?array $citas;

    public ?string $citaID;

    public ?string $doctorID;
    public ?string $fecha;
    public ?string $bloqueHoraID;

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

    public function loadCitas(int $cuentaID)
    {
        $pacienteID = $this->pdoUtils->fetchPacienteIdFromCuentaId($cuentaID);
        $this->citas = $this->pdoUtils->getAllCitaExtendedForPaciente(
            ['citaPacienteID' => $pacienteID, 'citaEstadoID' => CitaEntity::ESTADO_CITA_AGENDADA]);
    }

    public function cancelCita(int $cuentaID): bool
    {
        //First check if cita is of account
        $fluent = $this->pdoUtils->getFluentPdoBuilder();
        try
        {
            $citaPacienteID = $fluent
                ->from(CitaEntity::getTableName())
                ->asObject(CitaEntity::class)
                ->where(CitaEntity::getPrimaryKey(), $this->citaID)
                ->fetch('citaPacienteID');

            $pacienteID = $this->pdoUtils->fetchPacienteIdFromCuentaId($cuentaID);

        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        if (($citaPacienteID && $pacienteID) && ($citaPacienteID === $pacienteID))
        {
            if ($this->pdoUtils->cancelCita($this->citaID))
            {
                $codigo = $this->pdoUtils->fetchCodigoSeguimientoFromCitaID($this->citaID);
                Utilities::sendMailGoDaddy($this->pdoUtils->fetchPacienteEmailFromCita($this->citaID),
                    'Cita Agendada',
                    'Su cita con codigo de seguimiento ' . $codigo . ' fue cancelada');
                return true;
            }
        }

        return false;
    }

    public function rescheduleCita(int $cuentaID): bool
    {
        //First check if cita is of account
        $fluent = $this->pdoUtils->getFluentPdoBuilder();
        try
        {
            $citaPacienteID = $fluent
                ->from(CitaEntity::getTableName())
                ->asObject(CitaEntity::class)
                ->where(CitaEntity::getPrimaryKey(), $this->citaID)
                ->fetch('citaPacienteID');

            $pacienteID = $this->pdoUtils->fetchPacienteIdFromCuentaId($cuentaID);

        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        if (($citaPacienteID && $pacienteID) && ($citaPacienteID === $pacienteID))
        {
            if ($this->pdoUtils->rescheduleCita($this->citaID, $this->fecha, $this->bloqueHoraID))
            {
                try
                {
                    /** @var CitaExtendedEntity $cita */
                    $cita = $fluent
                        ->from(CitaEntity::getTableName())
                        ->asObject(CitaExtendedEntity::class)
                        ->select('bloquehora.*')
                        ->innerJoin(CitaEntity::getJoin(CitaEntity::BLOQUE_HORA))
                        ->where(CitaEntity::getPrimaryKey(), $this->citaID)
                        ->fetch();
                }
                catch (FluentPdoException $e)
                {
                }

                Utilities::sendMailGoDaddy($this->pdoUtils->fetchPacienteEmailFromCita($this->citaID),
                    'Cita Agendada',
                    'Su cita con codigo de seguimiento '
                    . $cita->citaCodigoSeguimineto .
                    ' fue reprogramada su nueva programacion es'
                    . $cita->citaFecha . ' ' . $cita->bloqueHoraHoraInicio);
                return true;
            }
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