<?php

namespace Shield1739\UTP\CitasCss\app\frontend\controllers\cita;

use Shield1739\UTP\CitasCss\app\frontend\models\cita\ScheduleCitaModel;
use Shield1739\UTP\CitasCss\core\common\FrontendController;
use Shield1739\UTP\CitasCss\core\Utilities;

class ScheduleCitaController extends FrontendController
{
    private ScheduleCitaModel $model;

    protected function init()
    {
        $this->model = new ScheduleCitaModel();
        $this->view = 'cita/scheduleCitaInfo';
        $this->scripts = ['lib/bootstrap-select/bootstrap-select', 'scheduleCita'];

        $this->addParam($this->model::MODEL_KEY, $this->model);
    }

    protected function doPost()
    {
        $this->model->loadData($this->request->getSanitizedData());

        if (!$this->session->get($this->model::STAGE_KEY))
        {
            $this->doGet();
        }
        else
        {
            $this->model->stage = $this->session->get($this->model::STAGE_KEY);
            if (isset($_POST['submit']) && $this->model->validate())
            {
                switch ($this->model->stage)
                {
                    case $this->model::STAGE_INFO_PACIENTE:
                        $this->session->set($this->model::STAGE_KEY, $this->model::STAGE_INFO_CITA);
                        break;
                    case $this->model::STAGE_INFO_CITA:
                        $this->session->set($this->model::STAGE_KEY, $this->model::STAGE_CONFIRM_INFO);
                        break;
                    case $this->model::STAGE_CONFIRM_INFO:

                        $cuentaID = null;

                        if ($this->session->isPaciente())
                        {
                            $cuentaID = $this->session->get($this->session::USER_KEY);
                        }

                        $this->model->insertCita($cuentaID);
                        $this->session->remove($this->model::STAGE_KEY);
                        $this->params[$this->session::SUCCESS_KEY] = '¡Cita Agendada Exitosamente!';
                        $this->view = 'cita/scheduleCitaEnd';
                        break;
                }
            }
            elseif (isset($_POST['reset']))
            {
                $resetStage = (int)$_POST['reset'];
                switch ($resetStage)
                {
                    case $this->model::STAGE_INFO_PACIENTE:
                        $this->session->set($this->model::STAGE_KEY, $this->model::STAGE_INFO_PACIENTE);
                        break;
                    case $this->model::STAGE_INFO_CITA:
                        $this->session->set($this->model::STAGE_KEY, $this->model::STAGE_INFO_CITA);
                        break;
                }
            }
        }

        $this->model->stage = $this->session->get($this->model::STAGE_KEY);
    }

    protected function doGet()
    {
        $this->session->set($this->model::STAGE_KEY, $this->model::STAGE_INFO_PACIENTE);

        if ($this->session->isPaciente() && $this->model->loadRegisteredPacienteData($this->session->get($this->session::USER_KEY)))
        {
            $this->session->set($this->model::STAGE_KEY, $this->model::STAGE_INFO_CITA);
        }

        $this->model->stage = $this->session->get($this->model::STAGE_KEY);
    }
}