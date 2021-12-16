<?php

namespace Shield1739\UTP\CitasCss\app\middlewares;

use Shield1739\UTP\CitasCss\core\common\Middleware;
use Shield1739\UTP\CitasCss\core\Response;
use Shield1739\UTP\CitasCss\core\Session;

class NoAuthAllowedMiddleware extends Middleware
{
    private Response $response;
    private Session $session;

    /**
     * @param \Shield1739\UTP\CitasCss\core\Response $response
     * @param \Shield1739\UTP\CitasCss\core\Session $session
     */
    public function __construct(Response $response, Session $session)
    {
        $this->response = $response;
        $this->session = $session;
    }

    public function execute()
    {
        if ($this->session->isAuth())
        {
            $this->response->redirect('/');
        }
    }
}