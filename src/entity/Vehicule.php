<?php
namespace App\Entity;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Persistable;

class Vehicule implements Persistable {
    private ObjectId $id;
    private string $model;
    private string $brand;
    private string $licence_plate;
    private string $informations;
    private string $km;

    public function __construct($model, $brand, $licence_plate, $informations, $km) {
        $this->model = $model;
        $this->brand = $brand;
        $this->licence_plate = $licence_plate;
        $this->informations = $informations;
        $this->km = $km;
    }

    public function bsonSerialize(): array {
        return [
            '_id' => $this->id,
            'model' => $this->model,
            'brand' => $this->brand,
            'licence_plate' => $this->licence_plate,
            'informations' => $this->informations,
            'km' => $this->km,
        ];
    }

    public function bsonUnserialize($data): void {
        $this->id = $data['_id'];
        $this->model = $data['model'];
        $this->brand = $data['brand'];
        $this->licence_plate = $data['licence_plate'];
        $this->informations = $data['informations'];
        $this->km = $data['km'];
    }
    
    public function getId(): ObjectId {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->model;
    }

    public function getLastName(): string {
        return $this->brand;
    }

    public function getlicence_plate(): string {
        return $this->licence_plate;
    }

    public function getinformations(): string {
        return $this->informations;
    }

    public function getkm(): string {
        return $this->km;
    }

    public function setId(ObjectId $id): void {
        $this->id = $id;
    }

    public function setModel(string $model): void {
        $this->model = $model;
    }

    public function setBrand(string $brand): void {
        $this->brand = $brand;
    }

    public function setLicencePlate(string $licence_plate): void {
        $this->licence_plate = $licence_plate;
    }

    public function setInformations(string $informations): void {
        $this->informations = $informations;
    }

    public function setkm(string $km): void {
        $this->km = $km;
    }
}