<?php

namespace Shield1739\UTP\CitasCss\app\frontend\controllers;

use Shield1739\UTP\CitasCss\app\frontend\models\RegisterModel;
use Shield1739\UTP\CitasCss\app\middlewares\NoAuthAllowedMiddleware;
use Shield1739\UTP\CitasCss\core\common\FrontendController;

class RegisterController extends FrontendController
{
    private RegisterModel $model;

    protected function init()
    {
        $this->registerMiddleware(new NoAuthAllowedMiddleware($this->response, $this->session));
        $this->model = new RegisterModel();
        $this->view = 'register';
        $this->params = [$this->model::MODEL_KEY => $this->model];
    }

    protected function doPost()
    {
        $this->model->loadData($this->request->getSanitizedData());

        if ($this->model->validate() && $this->model->register())
        {
            $this->session->setFlash($this->session::SUCCESS_KEY, '¡Registro Exitoso! Ya puede iniciar sesion.');
            $this->response->redirect('/');
        }
    }

    protected function doGet()
    {

    }
}