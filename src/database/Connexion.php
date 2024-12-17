<?php
namespace App\Database;

use \PDO;
interface Connexion {
    private static function initInstance(): void;

    public static function getInstance(): Object;

    public function getConnexion(): Object;
}