<?php

namespace Shield1739\UTP\CitasCss\app\frontend\controllers\cita;

use Shield1739\UTP\CitasCss\app\frontend\models\cita\ScheduleCitaModel;
use Shield1739\UTP\CitasCss\app\middlewares\NoGetAllowedMiddleware;
use Shield1739\UTP\CitasCss\core\common\FrontendController;

class ScheduleCitaAjaxController extends FrontendController
{
    private ScheduleCitaModel $model;

    protected function init()
    {
        $this->registerMiddleware(new NoGetAllowedMiddleware($this->request, $this->response, '/citas/agendar'));
        $this->layout = null;
        $this->model = new ScheduleCitaModel();
        $this->params = [$this->model::MODEL_KEY => $this->model];
    }

    protected function doPost()
    {
        $this->model->loadData($this->request->getSanitizedData());

        if ($this->model->fecha && $this->model->doctorID)
        {
            echo json_encode($this->model->getAllHorasOptions());
        }
        elseif ($this->model->especialidadID && $this->model->clinicaID)
        {
            echo json_encode($this->model->getAllDoctoresOptions());
        }
        elseif ($this->model->clinicaID)
        {
            echo json_encode($this->model->getAllEspecialidadesOptions());
        }
    }

    protected function doGet()
    {
        // TODO: Implement doGet() method.
    }
}