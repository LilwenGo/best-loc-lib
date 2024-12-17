<?php
namespace App\Entity;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Persistable;

class Customer implements Persistable {
    private ObjectId $id;
    private string $first_name;
    private string $last_name;
    private string $address;
    private string $email;
    private string $password;
    private string $permit_number;

    public function __construct($first_name, $last_name, $address, $email, $password, $permit_number) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->address = $address;
        $this->email = $email;
        $this->password = $password;
        $this->permit_number = $permit_number;
    }

    public function bsonSerialize(): array {
        return [
            '_id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'email' => $this->email,
            'password' => $this->password,
            'permit_number' => $this->permit_number
        ];
    }

    public function bsonUnserialize($data): void {
        $this->id = $data['_id'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->address = $data['address'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->permit_number = $data['permit_number'];
    }

    public function getId(): ObjectId {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->first_name;
    }

    public function getLastName(): string {
        return $this->last_name;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getPermitNumber(): string {
        return $this->permit_number;
    }

    public function setId(ObjectId $id): void {
        $this->id = $id;
    }

    public function setFirstName(string $name): void {
        $this->first_name = $name;
    }

    public function setLastName(string $name): void {
        $this->last_name = $name;
    }

    public function setAddress(string $address): void {
        $this->address = $address;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setPermitNumber(string $permit_number): void {
        $this->permit_number = $permit_number;
    }
}