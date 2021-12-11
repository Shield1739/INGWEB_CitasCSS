<?php

namespace Shield1739\UTP\CitasCss\app;

use citascss\app\models\entities\CuentaEntity;

class Config
{
    public static  function getConfig($dotenv)
    {
        $dotenv->load();
        return [
            'app' => [
                'defaultLayout' => $_ENV['APP_DEFAULT_LAYOUT'],
                'defaultErrorView' => $_ENV['APP_DEFAULT_ERROR_VIEW'],
                'userClass' => CuentaEntity::class
            ],
            'db' => [
                'dsn' => $_ENV['DB_DSN'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD']
            ]
        ];
    }
}