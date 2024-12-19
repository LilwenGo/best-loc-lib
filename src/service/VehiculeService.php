<?php
namespace App\Service;

use MongoDB\BSON\ObjectId;
use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;

class VehiculeService {
    private VehiculeRepository $repository;

    public function __construct() {
        $this->repository = new VehiculeRepository();
    }

    public function find(string $id): ?Vehicule {
        return $this->repository->find(new ObjectId($id));
    }

    public function getByLicencePlate(string $licence_plate): ?Vehicule {
        return $this->repository->getByLicencePlate($licence_plate);
    }

    public function countByKm(string $km, int $opNum): int {
        $res = $this->repository->countByKm($km, $opNum);
        $total = 0;
        foreach($res as $r) {
            $total = $r['total'];
        }
        return $total;
    }

    public function create(string $model, string $brand, string $licence_plate, string $informations, string $km): ?ObjectId {
        $res = $this->repository->create($model, $brand, $licence_plate, $informations, $km);
        return $res['rowCount'] > 0 && $res['id'] ? $res['id'] : null;
    }

    public function update(string $id, string $model, string $brand, string $licence_plate, string $informations, string $km): bool {
        return $this->repository->update(new ObjectId($id), $model, $brand, $licence_plate, $informations, $km);
    }

    public function delete(string $id): bool {
        return $this->repository->delete(new ObjectId($id));
    }
}