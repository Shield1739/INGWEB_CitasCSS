<?php

namespace Shield1739\UTP\CitasCss\app;

use Shield1739\UTP\CitasCss\app\entities\BloqueHoraEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaExtendedEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaPacienteInfoEntity;
use Shield1739\UTP\CitasCss\app\entities\CuentaEntity;
use Shield1739\UTP\CitasCss\app\entities\DoctorEntity;
use Shield1739\UTP\CitasCss\app\entities\PacienteEntity;
use Shield1739\UTP\CitasCss\core\common\FluentPDO;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class PDOUtils extends FluentPDO
{
    public function fetchPkWhere($className, array $where)
    {
        $fluent = $this->getFluentPdoBuilder();
        try
        {
            return $fluent
                ->from($className::getTableName())
                ->asObject($className)
                ->where($where)
                ->fetch($className::getPrimaryKey());
        }
        catch (FluentPdoException $e)
        {
            return null;
        }
    }

    public function fetchPacienteEmailFromCita($citaID)
    {
        $fluent = $this->getFluentPdoBuilder();
        try
        {
            $citaPacienteID = $fluent
                ->from(CitaEntity::getTableName())
                ->asObject(CitaEntity::class)
                ->where(CitaEntity::getPrimaryKey(), $citaID)
                ->fetch('citaPacienteID');

            if ($citaPacienteID)
            {
                $cuentaID = $fluent
                    ->from(PacienteEntity::getTableName())
                    ->asObject(PacienteEntity::class)
                    ->where('pacienteID', $citaPacienteID)
                    ->fetch('pacienteCuentaID');

                $correo = $fluent
                    ->from(CuentaEntity::getTableName())
                    ->asObject(CuentaEntity::class)
                    ->where('cuentaID', $cuentaID)
                    ->fetch('cuentaCorreo');
            }
            else
            {
                $correo = $fluent
                    ->from(CitaPacienteInfoEntity::getTableName())
                    ->asObject(CitaPacienteInfoEntity::class)
                    ->where('citaPacienteInfoID', $citaID)
                    ->fetch('citaPacienteInfoCorreo');
            }

            return $correo;
        }
        catch (FluentPdoException $e)
        {
            return null;
        }
    }

    public function fetchCodigoSeguimientoFromCitaID($citaID)
    {
        $fluent = $this->getFluentPdoBuilder();
        try
        {
            return $fluent
                ->from(CitaEntity::getTableName())
                ->asObject(CitaEntity::class)
                ->where('citaID', $citaID)
                ->fetch('citaCodigoSeguimineto');
        }
        catch (FluentPdoException $e)
        {
            return null;
        }
    }

    public function getAllCitaExtendedForPaciente(array $where): bool|array
    {
        $fluent = $this->getFluentPdoBuilder();
        try
        {
            return $fluent
                ->from(CitaEntity::getTableName())
                ->asObject(CitaExtendedEntity::class)
                ->select([
                    BloqueHoraEntity::getHoraInicioFormatKey() . " AS 'horaInicio'",
                    'cuentaNombre AS doctorCuentaNombre',
                    'cuentaApellido AS doctorCuentaApellido',
                    'clinica.*'
                ])
                ->innerJoin(BloqueHoraEntity::getTableName())
                ->innerJoin(DoctorEntity::getTableName())
                ->innerJoin(DoctorEntity::getJoin(DoctorEntity::CUENTA))
                ->innerJoin(DoctorEntity::getJoin(DoctorEntity::CLINICA))
                ->innerJoin(DoctorEntity::getJoin(DoctorEntity::CLINICA))
                ->where($where)
                ->orderBy('citaFecha')
                ->orderBy('bloqueHoraID')
                ->fetchAll();

        }
        catch (FluentPdoException $e)
        {
            return false;
        }
    }

    public function getAllCitaExtendedForDoctor(array $where): bool|array
    {
        $fluent = $this->getFluentPdoBuilder();
        try
        {
            return $fluent
                ->from(CitaEntity::getTableName())
                ->asObject(CitaExtendedEntity::class)
                ->select([
                    BloqueHoraEntity::getHoraInicioFormatKey() . " AS 'horaInicio'",
                    'bloqueHoraHoraInicio',
                    'cuentaNombre AS pacienteCuentaNombre',
                    'cuentaApellido AS pacienteCuentaApellido',
                    'citaPacienteInfoNombre',
                    'citaPacienteInfoApellido',
                    'clinica.*'
                ])
                ->innerJoin(BloqueHoraEntity::getTableName())
                ->leftJoin(PacienteEntity::getTableName())
                ->leftJoin(PacienteEntity::getJoin(PacienteEntity::CUENTA))
                ->leftJoin(CitaEntity::getJoin(CitaEntity::CITA_PACIENTE_INFO))
                ->innerJoin(CitaEntity::getJoin(CitaEntity::DOCTOR))
                ->innerJoin(DoctorEntity::getJoin(DoctorEntity::CLINICA))
                ->where($where)
                ->orderBy('citaFecha')
                ->orderBy('bloqueHoraID')
                ->fetchAll();
        }
        catch (FluentPdoException $e)
        {
            return false;
        }
    }

    public function fetchAllAvailableHoras(string $doctorID, string $fecha): array
    {
        $fluent = $this->getFluentPdoBuilder();

        try
        {
            $subQuery = $fluent
                ->from(CitaEntity::getTableName())
                ->select(['citaID', 'citaBloqueHoraID'], true)
                ->where('citaDoctorID = ' . $doctorID)
                ->where('citaFecha = \'' . $fecha .'\'')
                ->getQuery(false);

            $horas = $fluent
                ->from(BloqueHoraEntity::getTableName())
                ->asObject(BloqueHoraEntity::class)
                ->select([
                    'bloqueHoraID',
                    BloqueHoraEntity::getHoraInicioFormatKey() . " AS 'bloqueHoraHoraInicio'"
                ], true)
                ->disableSmartJoin()
                ->leftJoin('(' . $subQuery . ') c ON c.citaBloqueHoraID = ' . BloqueHoraEntity::getPrimaryKey())
                ->where('c.citaID', null)
                ->fetchAll();
        }
        catch (FluentPdoException $e)
        {
            return [];
        }

        return $horas ? $horas : [];
    }

    public function fetchPacienteIdFromCuentaId(string $cuentaID)
    {
        $fluent = $this->getFluentPdoBuilder();

        try
        {
            $pacienteID = $fluent
                ->from(PacienteEntity::getTableName())
                ->asObject(PacienteEntity::class)
                ->innerJoin(CuentaEntity::getTableName())
                ->where(CuentaEntity::getPrimaryKey(), $cuentaID)
                ->fetch(PacienteEntity::getPrimaryKey());
        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        return $pacienteID;
    }

    public function fetchDoctorIdFromCuentaId(string $cuentaID)
    {
        $fluent = $this->getFluentPdoBuilder();

        try
        {
            $doctorID = $fluent
                ->from(DoctorEntity::getTableName())
                ->asObject(DoctorEntity::class)
                ->innerJoin(CuentaEntity::getTableName())
                ->where(CuentaEntity::getPrimaryKey(), $cuentaID)
                ->fetch(DoctorEntity::getPrimaryKey());
        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        return $doctorID;
    }

    public function cancelCita(string $citaID): bool
    {
        $fluent = $this->getFluentPdoBuilder();

        try
        {
            $fluent
                ->update(CitaEntity::getTableName())
                ->set(['citaEstadoID' => CitaEntity::ESTADO_CITA_CANCELADA])
                ->where(CitaEntity::getPrimaryKey(), $citaID)
                ->execute();
        }
        catch (FluentPdoException $e)
        {
           return false;
        }

        return true;
    }

    public function rescheduleCita(string $citaID, string $fecha, string $bloqueHoraID): bool
    {
        $fluent = $this->getFluentPdoBuilder();

        try
        {
            $fluent
                ->update(CitaEntity::getTableName())
                ->set(['citaFecha' => $fecha, 'citaBloqueHoraID' => $bloqueHoraID])
                ->where(CitaEntity::getPrimaryKey(), $citaID)
                ->execute();
        }
        catch (FluentPdoException $e)
        {
            return false;
        }

        return true;
    }
}