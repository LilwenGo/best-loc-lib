<?php
namespace BestLocLib\Repository;

use BestLocLib\Database\MongoDBConnexion;
use BestLocLib\Entity\Customer;
use MongoDB\BSON\ObjectId;
use Dotenv\Dotenv;

/**
 * This class interacts with the customers collection from the MongoDB database
 */
class CustomerRepository {
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
     * Return a customer with matching id or null if not found
     * @param ObjectId $id id of the customer to find
     * @return Customer|null
     */
    public function find(ObjectId $id): ?Customer {
        return MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'customers')->findOne(['_id' => $id]);
    }
    
    /**
     * Return a customer with matching email or null if not found
     * @param string $email
     * @return Customer|null
     */
    public function getByEmail(string $email): ?Customer {
        return MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'customers')->findOne(['email' => $email]);
    }

    /**
     * Insert a new customer in the database
     * @param string $first_name new customer's first_name
     * @param string $last_name new customer's last_name
     * @param string $adress new customer's address
     * @param string $email new customer's email
     * @param string $password new customer's password
     * @param string $permit_number new customer's permit_number
     * @return array
     */
    public function create(string $first_name, string $last_name, string $adress, string $email, string $password, string $permit_number): array {
        $customer = new Customer($first_name, $last_name, $adress, $email, $password, $permit_number);
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'customers')->insertOne($customer);
        return [
            'id' => $result->getInsertedId(),
            'rowCount' => $result->getInsertedCount()
        ];
    }

    /**
     * Update a customer in the database
     * @param ObjectId $id id of the customer to update
     * @param string $first_name new customer's first_name
     * @param string $last_name new customer's last_name
     * @param string $adress new customer's address
     * @param string $email new customer's email
     * @param string $password new customer's password
     * @param string $permit_number new customer's permit_number
     * @return array
     */
    public function update(ObjectId $id, string $first_name, string $last_name, string $adress, string $email, string $password, string $permit_number): bool {
        $customer = new Customer($first_name, $last_name, $adress, $email, $password, $permit_number);
        $customer->setId($id);
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'customers')->updateOne(['_id' => $id], ['$set' => $customer]);
        return $result->getModifiedCount() > 0;
    }

    /**
     * Delete a customer from database
     * @param ObjectId $id id of the customer to delete
     * @return bool
     */
    public function delete(ObjectId $id): bool {
        $result = MongoDBConnexion::getInstance()->getConnexion()->selectCollection($this->database, 'customers')->deleteOne(['_id' => $id]);
        return $result->getDeletedCount() > 0;
    }
}