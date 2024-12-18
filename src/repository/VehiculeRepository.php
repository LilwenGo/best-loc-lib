<?php
namespace App\Repository;

use App\Database\MongoDBConnexion;
use App\Entity\Vehicule;
use MongoDB\BSON\ObjectId;
use Dotenv\Dotenv;

class VehiculeRepository {
    private string $database;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../..');
        $dotenv->load();
        $this->database = $_ENV['MDB_NAME'];
    }

    public function getDatabase() {
        return $this->database;
    }

    public function find(ObjectId $id): ?Vehicule {
        return MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->findOne(['_id' => $id]);
    }

    public function create(string $model, string $brand, string $licence_plate, string $informations, string $km): array {
        $vehicule = new Vehicule($model, $brand, $licence_plate, $informations, $km);
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->insertOne($vehicule);
        return [
            'id' => $result->getInsertedId(),
            'rowCount' => $result->getInsertedCount()
        ];
    }

    public function update(ObjectId $id, string $model, string $brand, string $licence_plate, string $informations, string $km): bool {
        $vehicule = new Vehicule($model, $brand, $licence_plate, $informations, $km);
        $vehicule->setId($id);
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->updateOne(['_id' => $id], ['$set' => $vehicule]);
        return $result->getModifiedCount() > 0;
    }

    public function delete(ObjectId $id): bool {
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->deleteOne(['_id' => $id]);
        return $result->getDeletedCount() > 0;
    }
}