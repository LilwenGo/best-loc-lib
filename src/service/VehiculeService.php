<?php
namespace App\Service;

use MongoDB\BSON\ObjectId;
use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;

/**
 * This class allows us to interact with the VehiculeRepository
 */
class VehiculeService {
    /**
     * The instance of the VehiculeRepository
     * @var VehiculeRepository
     */
    private VehiculeRepository $repository;

    public function __construct() {
        $this->repository = new VehiculeRepository();
    }

    /**
     * Return the vehicule with matching id.
     * If vehicule is not found, return null.
     * @param string $id id of the vehicule to find
     * @return Vehicule|null
     */
    public function find(string $id): ?Vehicule {
        return $this->repository->find(new ObjectId($id));
    }

    /**
     * Return the vehicule with matching licence_plate.
     * If vehicule is not found, return null.
     * @param string $licence_plate licence_plate of the vehicule to find
     * @return Vehicule|null
     */
    public function getByLicencePlate(string $licence_plate): ?Vehicule {
        return $this->repository->getByLicencePlate($licence_plate);
    }

    /**
     * Return the count of the vehicules with more|less than the given km
     * @param string $km string of the number of km
     * @param int $opNum int representing how to compare the kms (1 to greater than, -1 to lower than)
     * @return int
     */
    public function countByKm(string $km, int $opNum): int {
        $res = $this->repository->countByKm($km, $opNum);
        $total = 0;
        foreach($res as $r) {
            $total = $r['total'];
        }
        return $total;
    }

    /**
     * Insert a new vehicule in the database
     * @param string $model new vehicule's model
     * @param string $brand new vehicule's brand
     * @param string $licence_plate new vehicule's licence_plate
     * @param string $informations new vehicule's informations
     * @param string $km new vehicule's km
     * @return ObjectId|null
     */
    public function create(string $model, string $brand, string $licence_plate, string $informations, string $km): ?ObjectId {
        $res = $this->repository->create($model, $brand, $licence_plate, $informations, $km);
        return $res['rowCount'] > 0 && $res['id'] ? $res['id'] : null;
    }

    /**
     * Update a vehicule in the database
     * @param string $id id of the vehicule to update
     * @param string $model new vehicule's model
     * @param string $brand new vehicule's brand
     * @param string $licence_plate new vehicule's licence_plate
     * @param string $informations new vehicule's informations
     * @param string $km new vehicule's km
     * @return bool
     */
    public function update(string $id, string $model, string $brand, string $licence_plate, string $informations, string $km): bool {
        return $this->repository->update(new ObjectId($id), $model, $brand, $licence_plate, $informations, $km);
    }

    /**
     * Delete a vehicule in the database
     * @param string $id id of the vehicule to delete
     * @return bool
     */
    public function delete(string $id): bool {
        return $this->repository->delete(new ObjectId($id));
    }
}