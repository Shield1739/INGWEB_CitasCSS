<?php

namespace Shield1739\UTP\CitasCss\app\middlewares;

use Shield1739\UTP\CitasCss\core\common\Middleware;
use Shield1739\UTP\CitasCss\core\exception\ForbiddenException;
use Shield1739\UTP\CitasCss\core\Session;

class OnlyPacienteAllowedMiddleware extends Middleware
{
    private Session $session;

    /**
     * @param \Shield1739\UTP\CitasCss\core\Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @throws \Shield1739\UTP\CitasCss\core\exception\ForbiddenException
     */
    public function execute()
    {
        if (!$this->session->isPaciente())
        {
            throw new ForbiddenException();
        }
    }
}