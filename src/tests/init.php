<?php
// r[($HX=@ka(T
// UzECUwm6@?,Q
// SSH
// M?D:hgdia8]#
// MYSQL
// u^XML00X2[,z

use Shield1739\UTP\CitasCss\tests\db_init;

require_once __DIR__ . "/../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/_resources");
$dotenv->load();
$config =  [
    'initdb' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'name' => $_ENV['DB_NAME']
    ],
];

$dbInit = new db_init(__DIR__."/_resources", $config);
$dbInit->runScriptsDown();
$dbInit->runScriptsUp();

