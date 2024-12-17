<?php
namespace App\Tests;

use App\Database\MongoDBConnexion;
use App\Database\MySQLConnexion;
use PHPUnit\Framework\TestCase;

final class ConnexionTest extends TestCase {
    public function testMySQLConnexion(): void {
        $connexion = MySQLConnexion::getInstance()->getConnexion();
        $this->assertNotNull($connexion);
    }
    
    public function testMongoDBConnexion(): void {
        $connexion = MongoDBConnexion::getInstance()->getConnexion();
        $this->assertNotNull($connexion);
    }
}