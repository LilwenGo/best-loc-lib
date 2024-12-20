<?php
namespace BestLocLib\Repository;

use BestLocLib\Database\MongoDBConnexion;
use BestLocLib\Entity\Vehicule;
use MongoDB\BSON\ObjectId;
use Dotenv\Dotenv;
use MongoDB\Driver\CursorInterface;
use \Iterator;

/**
 * This class interacts with the vehicules collection of the MongoDB database
 */
class VehiculeRepository {
    /**
     * The name of the database
     * @var string
     */
    private string $database;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../..');
        $dotenv->load();
        $this->database = $_ENV['MDB_NAME'];
    }

    /**
     * Returns the database name
     * @return string
     */
    public function getDatabase() {
        return $this->database;
    }

    /**
     * Return the vehicule with matching id or null if not found
     * @param ObjectId $id
     * @return Vehicule|null
     */
    public function find(ObjectId $id): ?Vehicule {
        return MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->findOne(['_id' => $id]);
    }
    
    /**
     * Return the vehicule with matching licence_plate or null if not found
     * @param ObjectId $id
     * @return Vehicule|null
     */
    public function getByLicencePlate(string $licence_plate): ?Vehicule {
        return MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->findOne(['licence_plate' => $licence_plate]);
    }

    /**
     * Return an array of the vehicules having a number of km bigger|smaller than given
     * @param string $km string of the number of km
     * @param int $comparator int representing how to compare kms (1 to greater than, -1 to lower than)
     * @return Iterator|CursorInterface
     */
    public function countByKm(string $km, int $comparator): CursorInterface|Iterator {
        return MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->aggregate([
            [
                '$addFields' => [
                    'km_num' => ['$toInt' => '$km']
                ]
            ],
            [
                '$match' => [
                    'km_num' => [$comparator > 0 ? '$gt' : '$lt' => intval($km)]
                ]
            ],
            [
                '$count' => 'total'
            ]
        ]);
    }

    /**
     * Insert a new vehicule in the database
     * @param string $model new vehicule's model
     * @param string $brand new vehicule's brand
     * @param string $licence_plate new vehicule's licence_plate
     * @param string $informations new vehicule's informations
     * @param string $km new vehicule's km
     * @return array
     */
    public function create(string $model, string $brand, string $licence_plate, string $informations, string $km): array {
        $vehicule = new Vehicule($model, $brand, $licence_plate, $informations, $km);
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->insertOne($vehicule);
        return [
            'id' => $result->getInsertedId(),
            'rowCount' => $result->getInsertedCount()
        ];
    }

    /**
     * Update a vehicule in the database
     * @param ObjectId $id id of the vehicule to update
     * @param string $model new vehicule's model
     * @param string $brand new vehicule's brand
     * @param string $licence_plate new vehicule's licence_plate
     * @param string $informations new vehicule's informations
     * @param string $km new vehicule's km
     * @return array
     */
    public function update(ObjectId $id, string $model, string $brand, string $licence_plate, string $informations, string $km): bool {
        $vehicule = new Vehicule($model, $brand, $licence_plate, $informations, $km);
        $vehicule->setId($id);
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->updateOne(['_id' => $id], ['$set' => $vehicule]);
        return $result->getModifiedCount() > 0;
    }

    /**
     * Delete a vehicule in the database
     * @param ObjectId $id id of the vehicule to delete
     * @return bool
     */
    public function delete(ObjectId $id): bool {
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'vehicules')->deleteOne(['_id' => $id]);
        return $result->getDeletedCount() > 0;
    }
}