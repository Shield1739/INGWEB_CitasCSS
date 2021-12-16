<?php

namespace Shield1739\UTP\CitasCss\app\frontend\models\cita;

use Shield1739\UTP\CitasCss\app\entities\BloqueHoraEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaPacienteInfoEntity;
use Shield1739\UTP\CitasCss\app\entities\ClinicaEntity;
use Shield1739\UTP\CitasCss\app\entities\CuentaEntity;
use Shield1739\UTP\CitasCss\app\entities\DoctorEntity;
use Shield1739\UTP\CitasCss\app\entities\EspecialidadEntity;
use Shield1739\UTP\CitasCss\app\entities\PacienteEntity;
use Shield1739\UTP\CitasCss\core\common\Model;
use Shield1739\UTP\CitasCss\core\Utilities;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class ScheduleCitaModel extends Model
{
    public const STAGE_KEY = 'scheduleCitaStage';
    public const STAGE_INFO_PACIENTE = 1;
    public const STAGE_INFO_CITA = 2;
    public const STAGE_CONFIRM_INFO = 3;

    public int $stage;

    public CitaEntity $cita;
    public CitaPacienteInfoEntity $citaPacienteInfo;

    public ?string $clinicaID;
    public ?string $especialidadID;
    public ?string $doctorID;
    public ?string $fecha;
    public ?string $bloqueHoraID;
    public ?string $motivo;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->stage = -1;
        $this->cita = new CitaEntity();
        $this->citaPacienteInfo = new CitaPacienteInfoEntity();
        $this->clinicaID = null;
        $this->especialidadID = null;
        $this->doctorID = null;
        $this->fecha = null;
        $this->bloqueHoraID = null;
        $this->motivo = null;
    }

    public function loadData($data)
    {
        parent::loadData($data);

        if (!ctype_digit($this->clinicaID))
        {
            $this->clinicaID = null;
        }

        if (!ctype_digit($this->especialidadID))
        {
            $this->especialidadID = null;
        }

        if (!ctype_digit($this->doctorID))
        {
            $this->doctorID = null;
        }

        if(!strtotime($this->fecha))
        {
            $this->fecha = null;
        }

        if (!ctype_digit($this->bloqueHoraID))
        {
            $this->bloqueHoraID = null;
        }
    }

    public function loadRegisteredPacienteData(int $cuentaID): bool
    {
        $fluent = $this->pdoUtils->getFluentPdoBuilder();
        /** @var CitaPacienteInfoEntity $pacienteInfo */
        $pacienteInfo = null;
        try
        {
            $pacienteInfo = $fluent
                ->from(CuentaEntity::getTableName())
                ->asObject(CitaPacienteInfoEntity::class)
                ->innerJoin(CuentaEntity::getJoin(CuentaEntity::PACIENTE))
                ->where(CuentaEntity::getPrimaryKey(), $cuentaID)
                ->select([
                    'cuentaCorreo AS citaPacienteInfoCorreo',
                    'cuentaCedula AS citaPacienteInfoCedula',
                    'pacienteNSS AS citaPacienteInfoNSS',
                    'cuentaNombre AS citaPacienteInfoNombre',
                    'cuentaApellido AS citaPacienteInfoApellido',
                    'pacienteNumeroContacto AS citaPacienteInfoNumeroContacto'
                ], true)
                ->fetch();
        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        if ($pacienteInfo)
        {
            $this->citaPacienteInfo = $pacienteInfo;
            return true;
        }

        return false;
    }

    public function getAllClinicasOptions(): array
    {
        try
        {
            $clinicas = $this->pdoUtils->fetchAllFromWhere(ClinicaEntity::getTableName(), [], ClinicaEntity::class);
        }
        catch (FluentPdoException $e)
        {
            return [];
        }

        if (!$clinicas)
        {
            return [];
        }

        $options = [];
        /** @var ClinicaEntity $clinica */
        foreach ($clinicas as $clinica)
        {
            $options[$clinica->clinicaID] = [$clinica->clinicaNombre, $clinica->clinicaDireccion];
        }
        return $options;
    }

    public function getAllEspecialidadesOptions(): array
    {
        if (is_null($this->clinicaID))
        {
            return [];
        }

        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            $especialidades = $fluent
                ->from(EspecialidadEntity::getTableName())
                ->asObject(EspecialidadEntity::class)
                ->distinct(true)
                ->innerJoin(EspecialidadEntity::getJoin(EspecialidadEntity::DOCTOR_ESPECIALIDAD))
                ->innerJoin(EspecialidadEntity::getJoin(EspecialidadEntity::DOCTOR_ESPECIALIDAD_DOCTOR))
                ->where('doctorClinicaID', $this->clinicaID)
                ->fetchAll();
        }
        catch (FluentPdoException $e)
        {
            return [];
        }

        if (is_null($especialidades))
        {
            return [];
        }

        $options = [];
        /** @var EspecialidadEntity $especialidad */
        foreach ($especialidades as $especialidad)
        {
            $options[$especialidad->especialidadID] = $especialidad->especialidadNombre;
        }
        return $options;
    }

    public function getAllDoctoresOptions(): array
    {
        if (is_null($this->especialidadID) || is_null($this->clinicaID))
        {
            return [];
        }

        $fluent = $this->pdoUtils->getFluentPdoBuilder();

        try
        {
            $doctores = $fluent
                ->from(DoctorEntity::getTableName())
                ->asObject(DoctorEntity::class)
                ->select(['cuentaNombre', 'cuentaApellido'])
                ->asObject(DoctorEntity::class)
                ->innerJoin(DoctorEntity::getJoin(DoctorEntity::DOCTOR_ESPECIALIDAD))
                ->innerJoin(DoctorEntity::getJoin(DoctorEntity::CUENTA))
                ->where(['doctorEspecialidadEspecialidadID' => $this->especialidadID, 'doctorClinicaID' => $this->clinicaID])
                ->fetchAll();
        }
        catch (FluentPdoException $e)
        {
            return [];
        }

        if (is_null($doctores))
        {
            return [];
        }

        $options = [];
        /** @var DoctorEntity $doctor */
        foreach ($doctores as $doctor)
        {
            $options[$doctor->doctorID] = $doctor->getFullName();
        }

        return $options;
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

    public function insertCita(?int $cuentaID)
    {
        $pacienteID = null;

        if ($cuentaID)
        {
            //$pacienteID = $this->pdoUtils->getPacienteIdFromCuentaID($cuentaID);
            $pacienteID = $this->pdoUtils->fetchPkWhere(PacienteEntity::class, ['pacienteCuentaID' => $cuentaID]);
        }

        $this->cita->citaEstadoID = $this->cita::ESTADO_CITA_AGENDADA;
        $this->cita->citaDoctorID = $this->doctorID;
        $this->cita->citaPacienteID = $pacienteID ?: null;
        $this->cita->citaFecha = $this->fecha;
        $this->cita->citaBloqueHoraID = $this->bloqueHoraID;
        $this->cita->citaMotivo = $this->motivo;
        $this->cita->citaCodigoSeguimineto = $this->getUniqueCodigoSeguimiento();

        try
        {
            $citaID = $this->pdoUtils->insertEntity($this->cita, $this->getEntityAttributes('cita'));

            if (is_null($pacienteID))
            {
                $this->citaPacienteInfo->citaPacienteInfoID = $citaID;
                $this->pdoUtils->insertEntity($this->citaPacienteInfo, $this->getEntityAttributes('citaPacienteInfo'));
            }
        }
        catch (FluentPdoException $e)
        {
        }

        Utilities::sendMailGoDaddy($this->citaPacienteInfo->citaPacienteInfoCorreo,
            'Cita Agendada',
            'Su cita fue agendada exitosamente. Su codigo de seguimiento es: ' . $this->cita->citaCodigoSeguimineto);
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

    /**
     * @inheritDoc
     */
    public function getAllAttributes(): array
    {
        return [
            self::MODEL_KEY => [
                'clinicaID',
                'especialidadID',
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
                'clinicaID' => [[self::RULE_REQUIRED_WHEN, 'when' => $this->isStageInfoCita()]],
                'especialidadID' => [[self::RULE_REQUIRED_WHEN, 'when' => $this->isStageInfoCita()]],
                'doctorID' => [[self::RULE_REQUIRED_WHEN, 'when' => $this->isStageInfoCita()]],
                'fecha' => [[self::RULE_REQUIRED_WHEN, 'when' => $this->isStageInfoCita()], self::RULE_WORK_DAY],
                'bloqueHoraID' => [[self::RULE_REQUIRED_WHEN, 'when' => $this->isStageInfoCita()]],
                'motivo' => [[self::RULE_MAX, 'max' => 50]],
            ],
            'cita' => [

            ],
            'citaPacienteInfo' => [
                'citaPacienteInfoCorreo' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_MAX, 'max' => 255]],
                'citaPacienteInfoCedula' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 30]], //TODO ADD CEDULA RULE REMOVE BAD CEDUAL FROM INIT
                'citaPacienteInfoNombre' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 40]],
                'citaPacienteInfoApellido' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 40]],
                'citaPacienteInfoNSS' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 30]],
                'citaPacienteInfoNumeroContacto' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 20]]
            ],
        ];
    }

    /**
     * Stage Getters
     */

    public function isStageInfoPaciente(): bool
    {
        return $this->stage === self::STAGE_INFO_PACIENTE;
    }

    public function isStageInfoCita(): bool
    {
        return $this->stage === self::STAGE_INFO_CITA;
    }

    public function isStageConfirmInfo(): bool
    {
        return $this->stage === self::STAGE_CONFIRM_INFO;
    }
}