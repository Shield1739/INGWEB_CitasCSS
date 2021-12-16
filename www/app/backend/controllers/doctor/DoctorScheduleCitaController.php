<?php

namespace Shield1739\UTP\CitasCss\app\backend\controllers\doctor;

use Shield1739\UTP\CitasCss\app\backend\models\doctor\DoctorScheduleCitaModel;
use Shield1739\UTP\CitasCss\app\middlewares\OnlyDoctorAllowedMiddleware;
use Shield1739\UTP\CitasCss\core\common\BackendController;

class DoctorScheduleCitaController extends BackendController
{
    private DoctorScheduleCitaModel $model;

    protected function init()
    {
        $this->registerMiddleware(new OnlyDoctorAllowedMiddleware($this->session));
        $this->model = new DoctorScheduleCitaModel();
        $this->layout = 'doctor';
        $this->view = 'doctor/doctorScheduleCita';
        $this->scripts = [
            'lib/bootstrap-select/bootstrap-select',
            'doctorScheduleCita'
        ];

        $this->model->setDoctorID($this->session->get($this->session::USER_KEY));
        $this->addParam($this->model::MODEL_KEY, $this->model);
    }

    protected function doPost()
    {
        $this->model->loadData($this->request->getSanitizedData());

        if (isset($_POST['submit']) && $this->model->validate())
        {
            $this->model->insertCita();
            $this->session->setFlash($this->session::SUCCESS_KEY, 'Cita Agendada Exitosamente!');
            $this->response->redirect('/doctor/citas');
        }
        else // AJAX
        {
            echo json_encode($this->model->getAllHorasOptions());
        }
    }

    protected function doGet()
    {
        // TODO: Implement doGet() method.
    }
}