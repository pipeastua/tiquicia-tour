<?php

class DataBase
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            self::$instance = self::connect();
        }
        return self::$instance;
    }

    private static function connect(): PDO
    {
        $config = self::getConfig();
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ];

        try {
            if ($config['socket'] && file_exists($config['socket'])) {
                $dsn = "mysql:unix_socket={$config['socket']};dbname={$config['dbname']};charset=utf8mb4";
            } else {
                $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8mb4";
            }

            return new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            error_log('Error de conexión a la base de datos: ' . $e->getMessage());
            die('Error de conexión a la base de datos. Intente más tarde.');
        }
    }

    private static function getConfig(): array
    {
        $os = strtoupper(substr(PHP_OS, 0, 3));
        if ($os === 'WIN') {
            return [
                'host' => 'localhost',
                'port' => 3306,
                'dbname' => 'tiquicia-tour',
                'username' => 'root',
                'password' => '',
                'socket' => null
            ];
        }

        $possibleSockets = [
            '/tmp/mysql.sock',
            '/Applications/MAMP/tmp/mysql/mysql.sock',
            '/opt/homebrew/var/mysql/mysql.sock',
            '/usr/local/var/mysql/mysql.sock',
        ];

        $socket = null;
        foreach ($possibleSockets as $possibleSocket) {
            if (file_exists($possibleSocket)) {
                $socket = $possibleSocket;
                break;
            }
        }

        return [
            'host' => 'localhost',
            'port' => 3306,
            'dbname' => 'tiquicia-tour',
            'username' => 'root',
            'password' => '',
            'socket' => $socket
        ];
    }
}
