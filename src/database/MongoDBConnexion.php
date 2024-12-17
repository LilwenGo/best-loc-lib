<?php
namespace App\Database;

use Dotenv\Dotenv;
use MongoDB\Client;
class MongoDBConnexion implements Connexion {
    private static MongoDBConnexion $instance;
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