<?php

namespace Shield1739\UTP\CitasCss\app\middlewares;

use Shield1739\UTP\CitasCss\core\common\Middleware;
use Shield1739\UTP\CitasCss\core\Request;
use Shield1739\UTP\CitasCss\core\Response;

class NoGetAllowedMiddleware extends Middleware
{
    private Request $request;
    private Response $response;

    public string $redirect;

    public function __construct(Request $request, Response $response, string $redirect = '/')
    {
        $this->request = $request;
        $this->response =$response;
        $this->redirect = $redirect;
    }

    public function execute()
    {
        if ($this->request->isGet())
        {
            $this->response->redirect($this->redirect);
        }
    }
}