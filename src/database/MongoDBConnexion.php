<?php
namespace App\Database;

use Dotenv\Dotenv;
use MongoDB\Client;

/**
 * This class is a singleton pattern for a MongoDB connexion
 */
class MongoDBConnexion implements Connexion {
    /**
     * The instance of the class containing the connexion
     * @var MongoDBConnexion
     */
    private static MongoDBConnexion $instance;
    /**
     * The database connexion
     * @var Client
     */
    private Client $connexion;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $uri = 'mongodb://'.$_ENV['MDB_USER'].':'.$_ENV['MDB_PASS'].'@'.$_ENV['MDB_SRV'].'/';
        $this->connexion = new Client($uri);
    }

    public static function initInstance(): void {
        self::$instance = new MongoDBConnexion();
    }

    public function getConnexion(): Client {
        return $this->connexion;
    }

    public static function getInstance(): MongoDBConnexion {
        if(!isset(self::$instance)) self::initInstance();
        return self::$instance;
    }
}