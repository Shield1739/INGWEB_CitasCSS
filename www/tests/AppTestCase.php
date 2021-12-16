<?php

namespace Shield1739\UTP\CitasCss\tests;

use Shield1739\UTP\CitasCss\app\PDOUtils;
use Dotenv\Dotenv;
use \PHPUnit\Framework\TestCase as BaseTestCase;
use Shield1739\UTP\CitasCss\core\Database;

class AppTestCase extends BaseTestCase
{
    protected array $config;
    protected Database $database;
    protected PDOUtils $pdoUtils;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/_resources");
        $dotenv->load();
        $this->config =  [
            'initdb' => [
                'dsn' => $_ENV['DB_DSN'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
                'name' => $_ENV['DB_NAME']
            ],
            'fulldb' => [
                'dsn' => $_ENV['DB_DSN'].';dbname='.$_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD']
            ]
        ];

        $this->database = new Database($this->config['fulldb']);
    }

}