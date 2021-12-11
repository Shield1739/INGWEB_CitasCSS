<?php

namespace Shield1739\UTP\CitasCss\app\backend\controllers;

use Shield1739\UTP\CitasCss\app\middlewares\NoGetAllowedMiddleware;
use Shield1739\UTP\CitasCss\core\common\BackendController;

class LogoutController extends BackendController
{
    protected function init()
    {
        $this->registerMiddleware(new NoGetAllowedMiddleware($this->request, $this->response));
    }

    protected function doPost()
    {
        $this->session->remove($this->session::USER_KEY);
        $this->session->remove($this->session::USER_TYPE_KEY);
        $this->response->redirect('/');
    }

    protected function doGet()
    {
    }
}