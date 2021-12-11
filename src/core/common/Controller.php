<?php

namespace Shield1739\UTP\CitasCss\core\common;

use Shield1739\UTP\CitasCss\core\Application;
use Shield1739\UTP\CitasCss\core\Request;
use Shield1739\UTP\CitasCss\core\Response;
use Shield1739\UTP\CitasCss\core\Session;

abstract class Controller
{
    protected const FRONTEND = 'frontend';
    protected const BACKEND = 'backend';

    protected Request $request;
    protected Response $response;
    protected Session $session;

    protected string $layoutModule;
    protected ?string $layout;
    protected string $viewModule;
    protected ?string $view;
    protected ?string $title;
    protected ?array $scripts;
    protected array $params;

    /** @var Middleware[] */
    protected array $middlewares;

    /**
     * @param \Shield1739\UTP\CitasCss\core\Request $request
     * @param \Shield1739\UTP\CitasCss\core\Response $response
     * @param \Shield1739\UTP\CitasCss\core\Session $session
     */
    public function __construct(Request $request, Response $response, Session $session)
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;

        //$this->layout = Application::$DEFAULT_LAYOUT;
        $this->view = null;
        $this->title = null;
        $this->scripts = [];
        $this->params = [];
        $this->middlewares = [];

        $this->init();
        $this->addParam('title', $this->title);
        $this->addParam('scripts', $this->scripts);
    }

    abstract protected function init();
    abstract protected function doPost();
    abstract protected function doGet();

    /**
     *
     */
    public function handle()
    {
        if ($this->request->isPost())
        {
            $this->doPost();
        }
        else
        {
            $this->doGet();
        }
    }

    /**
     * @param Middleware $middleware
     */
    public function registerMiddleware(Middleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addParam(string $key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * @return string|null
     */
    public function getLayout(): ?string
    {
        return $this->layout;
    }

    /**
     * @return array
     */
    public function getFullLayout(): array
    {
        return [$this->layoutModule, $this->layout];
    }

    /**
     * @return string|null
     */
    public function getView(): ?string
    {
        return $this->view;
    }

    /**
     * @return array
     */
    public function getFullView(): array
    {
        return [$this->viewModule, $this->view];
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return Middleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}