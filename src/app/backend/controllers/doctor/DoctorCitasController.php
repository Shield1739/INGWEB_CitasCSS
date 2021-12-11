<?php

namespace Shield1739\UTP\CitasCss\app\backend\controllers\doctor;

use DateTime;
use Shield1739\UTP\CitasCss\app\backend\models\doctor\DoctorCitasModel;
use Shield1739\UTP\CitasCss\app\middlewares\OnlyDoctorAllowedMiddleware;
use Shield1739\UTP\CitasCss\core\common\BackendController;

class DoctorCitasController extends BackendController
{
    private DoctorCitasModel $model;

    protected function init()
    {
        $this->registerMiddleware(new OnlyDoctorAllowedMiddleware($this->session));
        $this->model = new DoctorCitasModel();
        $this->layout = 'doctorCitas';
        $this->view = 'doctor/doctorCitas';
        $this->scripts = [
            'lib/bootstrap-select/bootstrap-select',
            'doctorCitas'
        ];

        $this->model->setDoctorID($this->session->get($this->session::USER_KEY));
        $this->addParam($this->model::MODEL_KEY, $this->model);
    }

    protected function doPost()
    {
        $this->model->loadData($this->request->getSanitizedData());

        if (isset($_POST['reschedule']))
        {
            if($this->model->validate() && $this->model->rescheduleCita())
            {
                $this->params[$this->session::SUCCESS_KEY] = '¡Cita Reprogramada Exitosamente!';
                $this->model->citaID = null;
            }
        }
        elseif (isset($_POST['cancel']))
        {
            if($this->model->cancelCita())
            {
                $this->params[$this->session::SUCCESS_KEY] = '¡Cita Cancelada Exitosamente!';
                $this->model->citaID = null;
            }
        }
        elseif (isset($_POST['ajax'])) // AJAX POST
        {
            $this->layout = null;
            $this->view = null;
            echo json_encode($this->model->getAllHorasOptions());
        }

        $fecha = new DateTime();
        $this->model->loadWeekRange($fecha->format('Y-m-d'));
        $this->model->loadCitas($this->session->get($this->session::USER_KEY));
    }

    protected function doGet()
    {
        $fecha = new DateTime();
        $this->model->loadWeekRange($fecha->format('Y-m-d'));
        $this->model->loadCitas($this->session->get($this->session::USER_KEY));
    }
}