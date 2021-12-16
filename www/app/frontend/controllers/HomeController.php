<?php

namespace Shield1739\UTP\CitasCss\app\frontend\controllers;

use Shield1739\UTP\CitasCss\core\common\FrontendController;

class HomeController extends FrontendController
{
    protected function init()
    {
        $this->title = 'Inicio';
        $this->view = 'home';
    }

    protected function doPost()
    {

    }

    protected function doGet()
    {

    }
}