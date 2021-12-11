<?php

namespace Shield1739\UTP\CitasCss\app\backend\controllers\paciente;

use Shield1739\UTP\CitasCss\app\backend\models\paciente\PacienteCitasModel;
use Shield1739\UTP\CitasCss\app\middlewares\OnlyPacienteAllowedMiddleware;
use Shield1739\UTP\CitasCss\core\common\BackendController;

class PacienteCitasController extends BackendController
{
    private PacienteCitasModel $model;

    protected function init()
    {
        $this->registerMiddleware(new OnlyPacienteAllowedMiddleware($this->session));
        $this->model = new PacienteCitasModel();
        $this->view = 'paciente/pacienteCitas';
        $this->scripts = ['lib/bootstrap-select/bootstrap-select', 'pacienteReprogramar'];

        $this->addParam($this->model::MODEL_KEY, $this->model);
    }

    protected function doPost()
    {
        $this->model->loadData($this->request->getSanitizedData());

        if (isset($_POST['reschedule']))
        {
            if($this->model->validate())
            {
                $this->model->rescheduleCita($this->session->get($this->session::USER_KEY));
                $this->params[$this->session::SUCCESS_KEY] = '¡Cita Reprogramada Exitosamente!';
                $this->model->citaID = null;
                $this->model->doctorID = null;
            }
        }
        elseif (isset($_POST['cancel']))
        {
            if($this->model->cancelCita($this->session->get($this->session::USER_KEY)))
            {
                $this->params[$this->session::SUCCESS_KEY] = '¡Cita Cancelada Exitosamente!';
            }
        }
        elseif (isset($_POST['ajax'])) // AJAX POST
        {
            $this->layout = null;
            $this->view = null;
            echo json_encode($this->model->getAllHorasOptions());
        }

        $this->model->loadCitas($this->session->get($this->session::USER_KEY));
    }

    protected function doGet()
    {
        $this->model->loadCitas($this->session->get($this->session::USER_KEY));
    }
}