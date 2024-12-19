<?php
namespace App\Service;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use MongoDB\BSON\ObjectId;

class CustomerService {
    private CustomerRepository $repository;

    public function __construct() {
        $this->repository = new CustomerRepository();
    }

    public function find(string $id): ?Customer {
        return $this->repository->find(new ObjectId($id));
    }

    public function getByEmail(string $email): ?Customer {
        return $this->repository->getByEmail($email);
    }

    public function create(string $first_name, string $last_name, string $adress, string $email, string $password, string $permit_number): ?ObjectId {
        $res = $this->repository->create($first_name, $last_name, $adress, $email, password_hash($password, PASSWORD_BCRYPT), $permit_number);
        return $res['rowCount'] > 0 && $res['id'] ? $res['id'] : null;
    }

    public function update(string $id, string $first_name, string $last_name, string $adress, string $email, string $password, string $permit_number): bool {
        return $this->repository->update(new ObjectId($id), $first_name, $last_name, $adress, $email, password_hash($password, PASSWORD_BCRYPT), $permit_number);
    }

    public function delete(string $id): bool {
        return $this->repository->delete(new ObjectId($id));
    }
}