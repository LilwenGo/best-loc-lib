<?php
namespace App\Database;

use Dotenv\Dotenv;
use \PDO;

/**
 * This class is a singleton pattern for a MySQL connexion
 */
class MySQLConnexion implements Connexion {
    /**
     * The instance of the class containing the connexion
     * @var MySQLConnexion
     */
    private static MySQLConnexion $instance;
    /**
     * The database connexion
     * @var PDO
     */
    private PDO $connexion;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $this->connexion = new PDO(
            'mysql:host='.$_ENV['MYSQL_SRV'].';dbname=' . $_ENV['MYSQL_DBNAME'] . ';charset=utf8;',
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASS']
        );
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function initInstance(): void {
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