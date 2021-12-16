<?php

namespace Shield1739\UTP\CitasCss\tests;

use Shield1739\UTP\CitasCss\core\Database;

class db_init
{
    private const UP = 'up';
    private const DOWN = 'down';

    public string $rootPath;
    public Database $database;

    private string $dbname;

    public function __construct($rootPath, array $config)
    {
        $this->rootPath = $rootPath;
        $this->database = new Database($config['initdb']);
        $pdo = Database::getPDO();
        $pdo->exec('CREATE DATABASE IF NOT EXISTS '.$config['initdb']["name"].';');
        $this->dbname = $config['initdb']["name"];
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
        $files = scandir($this->rootPath . '/scripts');

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

            require_once $this->rootPath . '/scripts/' . $script;
            $className = pathinfo($script, PATHINFO_FILENAME);
            $instance = new $className();

            $this->log("Corriendo Script: $script");
            $query = $instance->$method();
            if (!is_null($query))
            {
                $statement = Database::getPDO()->prepare("USE $this->dbname; ".$query);
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
