<?php

ini_set('display_errors', 1);

require_once __DIR__ . '/../pdo.env';

class DatabasesManager
{
    private $pdo;

    public function __construct()
    {
        $options = [
            'host=' . DB_HOST,
            'dbname=' . DB_NAME,
            'port=' . DB_PORT
        ];

        $this->pdo = new PDO(DB_DRIVER . ':' . join(';', $options),
        DB_USER,
        DB_PASSWORD);

    }
    /**
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }


}