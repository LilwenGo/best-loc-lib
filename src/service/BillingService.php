<?php
namespace BestLocLib\Service;

use BestLocLib\Entity\Billing;
use BestLocLib\Repository\BillingRepository;

/**
 * This class allows to interact with the BillingRepository
 */
class BillingService {
    /**
     * The instance of BillingRepository
     * @var BillingRepository
     */
    private BillingRepository $repository;

    public function __construct() {
        $this->repository = new BillingRepository();
    }

    /**
     * Return an array of all the billings in the database
     * @return array
     */
    public function getAll(): array {
        return $this->repository->all();
    }

    /**
     * Return the billing with matching id.
     * If billing is not found return null.
     * @param int $id id to match
     * @return Billing|null
     */
    public function find(int $id): ?Billing {
        $billing = $this->repository->find($id);
        if(!$billing) {
            $billing = null;
        }
        return $billing;
    }

    /**
     * Return the billings with matching contract_id.
     * @param int $contract_id contract_id to match
     * @return array
     */
    public function getByContract(int $contract_id): array {
        return $this->repository->getByContract($contract_id);
    }

    /**
     * Insert a new billing in the database
     * @param int $contract_id new billing's contract_id
     * @param float $amount new billing's amount
     * @return int|null
     */
    public function create(int $contract_id, float $amount): ?int {
        $res = $this->repository->create($contract_id, $amount);
        return $res['rowCount'] > 0 && $res['id'] > 0 ? $res['id'] : null;
    }

    /**
     * Update a billing in the database with matching id
     * @param int $id billing's id to match
     * @param int $contract_id new billing's contract_id
     * @param float $amount new billing's amount
     * @return bool
     */
    public function update(int $id, int $contract_id, float $amount): bool {
        return $this->repository->update($id, $contract_id, $amount);
    }

    /**
     * Delete the matching billing in the database
     * @param int $id billing's id to match
     * @return bool
     */
    public function delete(int $id): bool {
        return $this->repository->delete($id);
    }
}