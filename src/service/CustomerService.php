<?php
namespace BestLocLib\Service;

use BestLocLib\Entity\Customer;
use BestLocLib\Repository\CustomerRepository;
use MongoDB\BSON\ObjectId;

/**
 * This class allows us to interact with the CustomerRepository
 */
class CustomerService {
    /**
     * The instance of the CustomerRepository
     * @var CustomerRepository
     */
    private CustomerRepository $repository;

    public function __construct() {
        $this->repository = new CustomerRepository();
    }

    /**
     * Return the Customer with matching id from database.
     * If customer is not found, returns null.
     * @param string $id customer's id to match
     * @return Customer|null
     */
    public function find(string $id): ?Customer {
        return $this->repository->find(new ObjectId($id));
    }

    /**
     * Return the Customer with matching email from database.
     * If customer is not found, return null.
     * @param string $email customer's email to match
     * @return Customer|null
     */
    public function getByEmail(string $email): ?Customer {
        return $this->repository->getByEmail($email);
    }

    /**
     * Insert a new customer in database
     * @param string $first_name new curtomer's first_name
     * @param string $last_name new curtomer's last_name
     * @param string $adress new curtomer's address
     * @param string $email new curtomer's email
     * @param string $password new curtomer's password (it will be hashed)
     * @param string $permit_number new curtomer's permit_number
     * @return ObjectId|null
     */
    public function create(string $first_name, string $last_name, string $adress, string $email, string $password, string $permit_number): ?ObjectId {
        $res = $this->repository->create($first_name, $last_name, $adress, $email, password_hash($password, PASSWORD_BCRYPT), $permit_number);
        return $res['rowCount'] > 0 && $res['id'] ? $res['id'] : null;
    }

    /**
     * Update from database the customer with matching id
     * @param string $id id of the customer to update
     * @param string $first_name new curtomer's first_name
     * @param string $last_name new curtomer's last_name
     * @param string $adress new curtomer's address
     * @param string $email new curtomer's email
     * @param string $password new curtomer's password (it will be hashed)
     * @param string $permit_number new curtomer's permit_number
     * @return bool
     */
    public function update(string $id, string $first_name, string $last_name, string $adress, string $email, string $password, string $permit_number): bool {
        return $this->repository->update(new ObjectId($id), $first_name, $last_name, $adress, $email, password_hash($password, PASSWORD_BCRYPT), $permit_number);
    }

    /**
     * Delete the mathing customer from database
     * @param string $id id of the customer to delete
     * @return bool
     */
    public function delete(string $id): bool {
        return $this->repository->delete(new ObjectId($id));
    }
}