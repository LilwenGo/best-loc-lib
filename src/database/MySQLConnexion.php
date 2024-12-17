<?php
namespace App\Database;

use Dotenv\Dotenv;
use \PDO;
class MySQLConnexion implements Connexion {
    private static MySQLConnexion $instance;
    private PDO $connexion;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->connexion = new PDO(
            'mysql:host='.getenv('MYSQL_SRV').';dbname=' . getenv('MYSQL_DBNAME') . ';charset=utf8;',
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASS')
        );
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private static function initInstance(): void {
        self::$instance = new MySQLConnexion();
    }

    public function getConnexion(): PDO {
        return $this->connexion;
    }

    public static function getInstance(): MySQLConnexion {
        if(!isset(self::$instance)) self::initInstance();
        return self::$instance;
    }
}