<?php
namespace App\Repository;

use App\Database\MongoDBConnexion;
use App\Entity\Customer;
use MongoDB\BSON\ObjectId;
use Dotenv\Dotenv;

class CustomerRepository {
    private string $database;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../..');
        $dotenv->load();
        $this->database = $_ENV['MDB_NAME'];
    }

    public function getDatabase() {
        return $this->database;
    }

    public function find(ObjectId $id): ?Customer {
        return MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'customers')->findOne(['_id' => $id]);
    }

    public function create(string $first_name, string $last_name, string $adress, string $email, string $password, string $permit_number): array {
        $customer = new Customer($first_name, $last_name, $adress, $email, $password, $permit_number);
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'customers')->insertOne($customer);
        return [
            'id' => $result->getInsertedId(),
            'rowCount' => $result->getInsertedCount()
        ];
    }

    public function update(ObjectId $id, string $first_name, string $last_name, string $adress, string $email, string $password, string $permit_number): bool {
        $customer = new Customer($first_name, $last_name, $adress, $email, $password, $permit_number);
        $customer->setId($id);
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'customers')->updateOne(['_id' => $id], ['$set' => $customer]);
        return $result->getModifiedCount() > 0;
    }

    public function delete(ObjectId $id): bool {
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'customers')->deleteOne(['_id' => $id]);
        return $result->getDeletedCount() > 0;
    }
}