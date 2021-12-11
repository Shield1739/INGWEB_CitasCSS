<?php

namespace Shield1739\UTP\CitasCss\core;

use PDO;

/**
 *  Saves Database connection information and creates PDO Objects with it
 */
class Database
{
    private static string $DSN;
    private static string $USER;
    private static string $PASSWORD;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        self::$DSN = $config['dsn'] ?? '';
        self::$USER = $config['user'] ?? '';
        self::$PASSWORD = $config['password'] ?? '';
    }

    /**
     * @return \PDO
     */
    public static function getPDO(): PDO
    {
        $pdo = new PDO(self::$DSN, self::$USER, self::$PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    /**
     * @param $message
     */
    private function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}