<?php
namespace BestLocLib\Tests;

use BestLocLib\Database\MongoDBConnexion;
use BestLocLib\Database\MySQLConnexion;
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