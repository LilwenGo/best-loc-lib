<?php
namespace App\Service;

use App\Entity\Contract;
use App\Repository\BillingRepository;
use App\Repository\ContractRepository;
use \DateTime;

class ContractService {
    private ContractRepository $repository;
    private BillingRepository $bRepository;

    public function __construct() {
        $this->repository = new ContractRepository();
        $this->bRepository = new BillingRepository();
    }

    public function getAll(?string $sort = null): array {
        return match($sort) {
            'customer' => $this->repository->allSortedByCustomer(),
            'vehicule' => $this->repository->allSortedByVehicule(),
            default => $this->repository->all()
        };
    }

    public function getByVehicule(string $vehicule_uid): array {
        return $this->repository->getByVehicule($vehicule_uid);
    }

    public function getCurrentLocsFromCustomer(string $customer_uid): array {
        return $this->repository->getCurrentLocations($customer_uid);
    }

    public function getLocLates(): array {
        return $this->repository->getLocLates();
    }

    public function countLocLatesBetweenDates(string $beginDate, string $endDate): int {
        return $this->repository->countLocLatesByDates(new DateTime($beginDate), new DateTime($endDate));
    }

    public function countLocLatesPerCustomer(): array {
        return $this->repository->countLocLatesPerCustomer();
    }

    public function isContractInvoiced(int $id): bool {
        $billings = $this->bRepository->getByContract($id);
        return count($billings) > 0;
    }

    public function getNotInvoiced(): array {
        $contracts = $this->getAll();
        foreach($contracts as $index => $contract) {
            if($this->isContractInvoiced($contract->getId())) {
                array_splice($contracts, $index, 1);
            }
        }
        return $contracts;
    }

    public function find(int $id): ?Contract {
        $contract = $this->repository->find($id);
        if(!$contract) {
            $contract = null;
        }
        return $contract;
    }

    public function create(string $vehicule_uid, string $customer_uid, string $sign_date, string $loc_begin_date, string $loc_end_date, string $returning_date, float $price): ?int {
        $res = $this->repository->create($vehicule_uid, $customer_uid, new DateTime($sign_date), new DateTime($loc_begin_date), new DateTime($loc_end_date), new DateTime($returning_date), $price);
        return $res['rowCount'] > 0 && $res['id'] > 0 ? $res['id'] : null;
    }

    public function update(int $id, string $vehicule_uid, string $customer_uid, string $sign_date, string $loc_begin_date, string $loc_end_date, string $returning_date, float $price): bool {
        return $this->repository->update($id, $vehicule_uid, $customer_uid, new DateTime($sign_date), new DateTime($loc_begin_date), new DateTime($loc_end_date), new DateTime($returning_date), $price);
    }

    public function delete(int $id): bool {
        return $this->repository->delete($id);
    }
}