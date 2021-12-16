<?php

namespace Shield1739\UTP\CitasCss\core\common;


use Shield1739\UTP\CitasCss\core\Request;
use Shield1739\UTP\CitasCss\core\Response;
use Shield1739\UTP\CitasCss\core\Session;

abstract class BackendController extends Controller
{
    public function __construct(Request $request, Response $response, Session $session)
    {
        $this->layoutModule = self::BACKEND;
        $this->layout = 'auth';
        $this->viewModule = self::BACKEND;
        parent::__construct($request, $response, $session);
    }
}