<?php

namespace Shield1739\UTP\CitasCss\core;

use JetBrains\PhpStorm\Pure;
use Shield1739\UTP\CitasCss\core\exception\NotFoundException;
use Shield1739\UTP\CitasCss\core\common\Controller;

/**
 *
 */
class Router
{
    /**
     * @var array Stores the apps path & controller routes path => controller
     */
    private array $routes;

    private Session $session;
    private Request $request;
    private Response $response;

    private ViewRenderer $viewRenderer;
    private ?Controller $controller;

    /**
     * @param Session $session
     * @param Request $request
     * @param Response $response
     */
    #[Pure] public function __construct(Session $session, Request $request, Response $response)
    {
        $this->routes = [];

        $this->session = $session;
        $this->request = $request;
        $this->response = $response;

        $this->viewRenderer = new ViewRenderer();
        $this->controller = null;
    }

    /**
     * Stores path and controller in routes
     *
     * @param string $path
     * @param $controller
     */
    public function addRoute(string $path, $controller)
    {
        $this->routes[$path] = $controller;
    }

    /**
     *  Router Resolve method.
     * @throws \Exception
     */
    public function dispatch(): string
    {
        $path = $this->request->getPath();
        $controllerClass = $this->routes[$path] ?? false;

        if (!$controllerClass)
        {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }

        $this->controller = new $controllerClass($this->request, $this->response, $this->session);

        $middlewares = $this->controller->getMiddlewares();
        foreach ($middlewares as $middleware)
        {
            $middleware->execute();
        }

        $this->controller->addParam(Session::USER_KEY, $this->session->get(Session::USER_KEY));
        $this->controller->addParam(Session::USER_TYPE_KEY, $this->session->get(Session::USER_TYPE_KEY));
        $this->controller->addParam(Session::SUCCESS_KEY, $this->session->getFlash(Session::SUCCESS_KEY));

        $this->controller->handle();

        if (is_null($this->controller->getView()))
        {
            return '';
        }
        if (is_null($this->controller->getLayout()))
        {
            return $this->viewRenderer->renderOnlyView($this->controller->getFullView(), $this->controller->getParams());
        }

        return $this->renderView($this->controller->getFullLayout(),
            $this->controller->getFullView(), $this->controller->getParams());
    }

    /**
     * @param array $layout
     * @param array $view
     * @param array $params
     *
     * @return string
     * @throws \Shield1739\UTP\CitasCss\core\exception\NotFoundException
     */
    public function renderView(array $layout, array $view, array $params = []): string
    {
        return $this->viewRenderer->renderView($layout, $view, $params);
    }
}