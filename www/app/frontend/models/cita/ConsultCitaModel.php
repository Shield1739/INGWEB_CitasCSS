<?php

namespace Shield1739\UTP\CitasCss\app\frontend\models\cita;

use Shield1739\UTP\CitasCss\app\entities\BloqueHoraEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaExtendedEntity;
use Shield1739\UTP\CitasCss\app\entities\CitaPacienteInfoEntity;
use Shield1739\UTP\CitasCss\app\entities\DoctorEntity;
use Shield1739\UTP\CitasCss\core\common\Model;
use Shield1739\UTP\CitasCss\fluentpdo\FluentPdoException;

class ConsultCitaModel extends Model
{
    public CitaExtendedEntity $cita;
    public CitaPacienteInfoEntity $citaPacienteInfo;

    public bool $validCodigo;
    public ?string $codigoSeguimiento;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->cita = new CitaExtendedEntity();
        $this->citaPacienteInfo = new CitaPacienteInfoEntity();
        $this->codigoSeguimiento = null;
        $this->validCodigo = false;
    }

    public function loadCita()
    {
        $citas = $this->pdoUtils->getAllCitaExtendedForPaciente(
            ['citaCodigoSeguimineto' => strtoupper($this->codigoSeguimiento)]);

        if ($citas)
        {
            /** @var CitaExtendedEntity $cita */
            $cita = $citas[0];
            if ($cita->citaID)
            {
                $this->validCodigo = true;
                $this->cita = $cita;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getAllAttributes(): array
    {
        return [
            self::MODEL_KEY => [
                'codigoSeguimiento'
            ],
            'cita' => [
                'citaID',
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
                'codigoSeguimiento' => [
                    self::RULE_REQUIRED,
                    [self::RULE_MAX, 'max' => 6],
                    [self::RULE_MIN, 'min' => 6]]
            ]
        ];
    }
}