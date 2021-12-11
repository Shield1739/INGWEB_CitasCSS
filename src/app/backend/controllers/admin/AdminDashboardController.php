<?php

namespace Shield1739\UTP\CitasCss\app\backend\controllers\admin;

use Shield1739\UTP\CitasCss\app\backend\models\admin\AdminDashboardModel;
use Shield1739\UTP\CitasCss\app\middlewares\OnlyAdminAllowedMiddleware;
use Shield1739\UTP\CitasCss\core\common\BackendController;

class AdminDashboardController extends BackendController
{
    private AdminDashboardModel $model;

    protected function init()
    {
        $this->registerMiddleware(new OnlyAdminAllowedMiddleware($this->session));
        $this->model = new AdminDashboardModel();
        $this->layout = 'admin';
        $this->view = 'admin/dashboard';
        $this->scripts = ['lib/bootstrap-select/bootstrap-select', 'adminDashboard'];
        $this->addParam($this->model::MODEL_KEY, $this->model);
    }

    protected function doPost()
    {
        $data = $this->request->getSanitizedData();

        // Clinica
        if (isset($data['createClinica']) && $this->model->insertClinica($data['clinicaNombre'], $data['clinicaDireccion']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Clinica Creada Exitosamente';
        }
        else if (isset($data['editClinica']) && $this->model->editClinica($data['clinicaID'], $data['clinicaNombre'], $data['clinicaDireccion']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Clinica Editada Exitosamente';
        }
        else if (isset($data['deleteClinica']) && $this->model->deleteClinica($data['clinicaID']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Clinica Borrada Exitosamente';
        }
        // Especialidad
        else if (isset($data['createEspecialidad']) && $this->model->insertEspecialidad($data['especialidadNombre']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Especialidad Creada Exitosamente';
        }
        else if (isset($data['editEspecialidad']) && $this->model->editEspecialidad($data['especialidadID'], $data['especialidadNombre']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Especialidad Editada Exitosamente';
        }
        else if (isset($data['deleteEspecialidad']) && $this->model->deleteEspecialidad($data['especialidadID']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Especialidad Borrada Exitosamente';
        }
        // Doctores
        else if (isset($data['createDoctor']) && $this->model->insertDoctor($data['doctorCorreo'], $data['doctorCedula'], $data['doctorNombre'], $data['doctorApellido'], $data['doctorContrasena']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Doctor Creada Exitosamente';
        }
        else if (isset($data['editDoctor']) && $this->model->editDoctor($data['doctorID'], $data['doctorCuentaID'], $data['doctorCorreo'], $data['doctorCedula'], $data['doctorNombre'], $data['doctorApellido'], $data['doctorContrasena'], $data['clinicaID']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Doctor Editado Exitosamente';
        }
        else if (isset($data['deleteDoctor']) && $this->model->deleteDoctor($data['doctorID']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Doctor Borrada Exitosamente';
        }
        else if (isset($data['addDoctorEspecialidad']) && $this->model->addDoctorEspecialidad($data['doctorID'], $data['especialidadID']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Doctor Borrada Exitosamente';
        }
        else if (isset($data['deleteDoctorEspecialidad']) && $this->model->deleteDoctorEspecialidad($data['doctorID'], $data['deleteDoctorEspecialidad']))
        {
            $this->params[$this->session::SUCCESS_KEY] = 'Doctor Borrada Exitosamente';
        }

        $this->model->loadCounts();
    }

    protected function doGet()
    {
        $this->model->loadCounts();
    }
}