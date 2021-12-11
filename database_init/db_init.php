<?php

use Shield1739\UTP\CitasCss\app\Config;
use Shield1739\UTP\CitasCss\core\Database;

class init
{
    private const UP = 'up';
    private const DOWN = 'down';

    public $rootPath;
    public Database $database;

    public function __construct($rootPath, array $config)
    {
        $this->rootPath = $rootPath;
        $this->database = new Database($config['db']);
    }

    public function runScriptsUp()
    {
        $this->runScripts(self::UP);
    }

    public function runScriptsDown()
    {
        $this->runScripts(self::DOWN);
    }

    private function runScripts($method)
    {
        $this->log("!~ Inicia Corrida de Scripts");

        $newScripts = [];
        $files = scandir($this->rootPath . '/database_init/scripts');

        if ($method === self::UP)
        {
            $this->log("!~ Metodo: UP");
        }
        elseif ($method === self::DOWN)
        {
            $this->log("!~ Metodo: DOWN");
            $files = array_reverse($files);
        }

        foreach ($files as $script)
        {
            if ($script === '.' || $script === '..') {
                continue;
            }

            require_once $this->rootPath . '/database_init/scripts/' . $script;
            $className = pathinfo($script, PATHINFO_FILENAME);
            $instance = new $className();

            $this->log("Corriendo Script: $script");
            $query = $instance->$method();
            if (!is_null($query))
            {
                $statement = Database::getPDO()->prepare($query);
                $statement->execute();
            }
            $this->log("Script Terminado: $script");
        }

        $this->log("!~ Termina Corrida de Scripts");
    }

    private function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}

//Composer Autoload
require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__)."/src/");

$init = new init(dirname(__DIR__), Config::getConfig($dotenv));

if (isset($argc))
{
    if ($argv[1] === 'up' || $argc === 1)
    {
        $init->runScriptsUp();
    }
    elseif ($argv[1] === 'down')
    {
        $init->runScriptsDown();
    }
    elseif ($argv[1] === 'reset')
    {
        $init->runScriptsDown();
        $init->runScriptsUp();
    }
    else
    {
        echo 'Error: Bad Input';
    }
}