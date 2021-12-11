<?php

namespace Shield1739\UTP\CitasCss\core;

use Exception;

/**
 *  Applications Main Class
 */
class Application
{
    /**
     * @var string Saves project ROOT Directory /src
     */
    public static string $ROOT_DIR;
    /**
     * @var string|mixed Saves the default view layout, in case one isn't specified
     */
    public static string $DEFAULT_LAYOUT;
    /**
     * @var string|mixed Saves the default error view
     */
    public static string $DEFAULT_ERROR_VIEW;

    private Database $db;

    private Session $session;
    private Request $request;
    private Response $response;
    private Router $router;

    /**
     * @param string $rootDir   App Root Directory /src
     * @param array $config     Includes all app specific configurations (Db, default views, etc...)
     */
    public function __construct(string $rootDir, array $config)
    {
        self::$ROOT_DIR = $rootDir;

        $appConfig = $config['app'];
        self::$DEFAULT_LAYOUT = $appConfig['defaultLayout'];
        self::$DEFAULT_ERROR_VIEW = $appConfig['defaultErrorView'];

        $this->db = new Database($config['db']);

        $this->session = new Session();
        $this->request = new Request();
        $this->response = new Response();

        $this->router = new Router($this->session, $this->request, $this->response);
    }

    /**
     *  Starts the router resolve path operations
     */
    public function run()
    {
        try
        {
            $app = $this->router->dispatch();
            if ($app != '')
            {
                echo $app;
            }
        }
        catch (Exception $e)
        {
            echo $this->router->renderView(
                ['frontend', self::$DEFAULT_LAYOUT],
                ['frontend', self::$DEFAULT_ERROR_VIEW],
                ['exception' => $e]);
        }
    }

    /**
     * Adds URL paths to the router to be resolved
     *
     * @param array|string  $route
     * @param mixed         $controller
     */
    public function addRoute(array|string $route, mixed $controller = [])
    {
        if (is_array($route))
        {
            foreach ($route as $path => $control)
            {
                $this->addRoute($path, $control);
            }
        }

        $this->router->addRoute($route, $controller);
    }
}