<?php
namespace App\Service;

use App\Entity\Billing;
use App\Repository\BillingRepository;

class BillingService {
    private BillingRepository $repository;

    public function __construct() {
        $this->repository = new BillingRepository();
    }

    public function getAll(): array {
        return $this->repository->all();
    }

    public function find(int $id): ?Billing {
        $billing = $this->repository->find($id);
        if(!$billing) {
            $billing = null;
        }
        return $billing;
    }

    public function getByContract(int $contract_id): array {
        return $this->repository->getByContract($contract_id);
    }

    public function create(int $contract_id, float $amount): ?int {
        $res = $this->repository->create($contract_id, $amount);
        return $res['rowCount'] > 0 && $res['id'] > 0 ? $res['id'] : null;
    }

    public function update(int $id, int $contract_id, float $amount): bool {
        return $this->repository->update($id, $contract_id, $amount);
    }

    public function delete(int $id): bool {
        return $this->repository->delete($id);
    }
}