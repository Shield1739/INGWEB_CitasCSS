<?php

namespace Shield1739\UTP\CitasCss\app\frontend\controllers;

use Shield1739\UTP\CitasCss\app\frontend\models\LoginModel;
use Shield1739\UTP\CitasCss\app\middlewares\NoAuthAllowedMiddleware;
use Shield1739\UTP\CitasCss\core\common\FrontendController;

class LoginController extends FrontendController
{
    private LoginModel $model;

    protected function init()
    {
        $this->registerMiddleware(new NoAuthAllowedMiddleware($this->response, $this->session));
        $this->model = new LoginModel();
        $this->view = 'login';
        $this->params[$this->model::MODEL_KEY] = $this->model;
    }

    protected function doPost()
    {
        $this->model->loadData($this->request->getSanitizedData());

        if ($this->model->validate() && $this->model->login())
        {
            $this->session->set($this->session::USER_KEY, $this->model->cuenta->cuentaID);
            $this->session->set($this->session::USER_TYPE_KEY, $this->model->cuenta->cuentaTipoID);
            $this->session->setFlash($this->session::SUCCESS_KEY, '¡Inicio de Sesion Exitoso!');
            $this->response->redirect('/');
        }
    }

    protected function doGet()
    {

    }
}