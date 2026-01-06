<?php
class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $config = include(__DIR__ . '/../config/database.php');
        try {
            $this->connection = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                $config['username'],
                $config['password']
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->exec("SET NAMES utf8");
        } catch (PDOException $e) {
            die("Помилка підключення до бази даних: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
