<?php

namespace Shield1739\UTP\CitasCss\app\frontend\controllers\cita;

use Shield1739\UTP\CitasCss\app\frontend\models\cita\ConsultCitaModel;
use Shield1739\UTP\CitasCss\core\common\FrontendController;
use function Sodium\add;

class ConsultCitaController extends FrontendController
{
    private ConsultCitaModel $model;

    protected function init()
    {
        $this->model = new ConsultCitaModel();
        $this->view = 'cita/consultCita';
        $this->addParam($this->model::MODEL_KEY, $this->model);
    }

    protected function doPost()
    {
        $this->model->loadData($this->request->getSanitizedData());

        if ($this->model->validate())
        {
            $this->model->loadCita();
        }
        else
        {
            $this->model->codigoSeguimiento = null;
        }
    }

    protected function doGet()
    {

    }
}