<?php

namespace Shield1739\UTP\CitasCss\app\backend\controllers\admin;

use Shield1739\UTP\CitasCss\app\backend\models\admin\AdminDashboardAjaxModel;
use Shield1739\UTP\CitasCss\app\backend\models\admin\AdminDashboardModel;
use Shield1739\UTP\CitasCss\app\middlewares\NoGetAllowedMiddleware;
use Shield1739\UTP\CitasCss\core\common\BackendController;

class AdminDashboardAjaxController extends BackendController
{
    private AdminDashboardModel $model;
    private AdminDashboardAjaxModel $ajaxModel;

    protected function init()
    {
        $this->registerMiddleware(new NoGetAllowedMiddleware($this->request, $this->response, '/admin/dashboard'));
        $this->layout = null;
        $this->model = new AdminDashboardModel();
        $this->ajaxModel = new AdminDashboardAjaxModel();
    }

    protected function doPost()
    {
        $requestData = $this->request->getSanitizedData();
        $action = $requestData['action'];

        $data = [];
        switch ($action)
        {
            case 'loadDoctor':
                $data['clinicas'] = $this->model->fetchAllClinicas();
                $data['clinica'] = $this->ajaxModel->fetchDoctorClinica($requestData['doctorID']);
                $data['especialidades'] = $this->ajaxModel->fetchDoctorEspecialidades($requestData['doctorID']);
                $data['allEspecialidades'] = $this->model->fetchAllEspecialidades();

                echo json_encode($data);
                break;
        }
    }

    protected function doGet()
    {
        // TODO: Implement doGet() method.
    }
}