<?php
namespace BestLocLib\Service;

use BestLocLib\Entity\Contract;
use BestLocLib\Repository\BillingRepository;
use BestLocLib\Repository\ContractRepository;
use \DateTime;

/**
 * This class allows us to interact with the ContractRepository
 */
class ContractService {
    /**
     * The instance of the ContractRepository
     * @var ContractRepository
     */
    private ContractRepository $repository;
    /**
     * The instance of a BillingRepository used in method isContractInvoiced()
     * @var BillingRepository
     */
    private BillingRepository $bRepository;

    public function __construct() {
        $this->repository = new ContractRepository();
        $this->bRepository = new BillingRepository();
    }

    /**
     * Return an array of all the contracts in database.
     * If sort is given, it sorts the result by 'customer' or 'vehicule'
     * @param string|null $sort string to sort ('customer'|'vehicule')
     * @return array
     */
    public function getAll(?string $sort = null): array {
        return match($sort) {
            'customer' => $this->repository->allSortedByCustomer(),
            'vehicule' => $this->repository->allSortedByVehicule(),
            default => $this->repository->all()
        };
    }

    /**
     * Return an array of the contracts with matching vehicule_uid
     * @param string $vehicule_uid vehicule_uid to match
     * @return array
     */
    public function getByVehicule(string $vehicule_uid): array {
        return $this->repository->getByVehicule($vehicule_uid);
    }

    /**
     * Return an array of the current contracts in the database with matching customer_uid
     * @param string $customer_uid customer_uid to match
     * @return array
     */
    public function getCurrentLocsFromCustomer(string $customer_uid): array {
        return $this->repository->getCurrentLocations($customer_uid);
    }

    /**
     * Return an array of all the contracts witch are late
     * @return array
     */
    public function getLocLates(): array {
        return $this->repository->getLocLates();
    }

    /**
     * Return the count of all the late contracts between two dates
     * @param string $beginDate string of the begin date
     * @param string $endDate string of the end date
     * @return int
     */
    public function countLocLatesBetweenDates(string $beginDate, string $endDate): int {
        return $this->repository->countLocLatesByDates(new DateTime($beginDate), new DateTime($endDate));
    }

    /**
     * Return the count of all the late contracts, grouped by customer
     * @return array
     */
    public function countLocLatesPerCustomer(): array {
        return $this->repository->countLocLatesPerCustomer();
    }

    /**
     * Return true if the given contract has at least one billing
     * @param int $id contract's id
     * @return bool
     */
    public function isContractInvoiced(int $id): bool {
        $billings = $this->bRepository->getByContract($id);
        return count($billings) > 0;
    }

    /**
     * Return an array of all the not invoiced contracts
     * @return array
     */
    public function getNotInvoiced(): array {
        $contracts = $this->getAll();
        foreach($contracts as $index => $contract) {
            if($this->isContractInvoiced($contract->getId())) {
                array_splice($contracts, $index, 1);
            }
        }
        return $contracts;
    }

    /**
     * Return the contract with matching id.
     * If contract is not found, return null.
     * @param int $id id to match
     * @return Contract|null
     */
    public function find(int $id): ?Contract {
        $contract = $this->repository->find($id);
        if(!$contract) {
            $contract = null;
        }
        return $contract;
    }

    /**
     * Insert a new contract in the database
     * @param string $vehicule_uid new contract's vehicule_uid
     * @param string $customer_uid new contract's customer_uid
     * @param string $sign_date new contract's sign_date
     * @param string|null $loc_begin_date new contract's loc_begin_date
     * @param string|null $loc_end_date new contract's loc_end_date
     * @param string|null $returning_date new contract's returning_date
     * @param float $price new contract's price
     * @return array
     */
    public function create(string $vehicule_uid, string $customer_uid, string $sign_date, ?string $loc_begin_date, ?string $loc_end_date, ?string $returning_date, float $price): ?int {
        $loc_begin_date = !is_null($loc_begin_date) ? new DateTime($loc_begin_date) : null;
        $loc_end_date = !is_null($loc_end_date) ? new DateTime($loc_end_date) : null;
        $returning_date = !is_null($returning_date) ? new DateTime($returning_date) : null;
        $res = $this->repository->create($vehicule_uid, $customer_uid, new DateTime($sign_date), $loc_begin_date, $loc_end_date, $returning_date, $price);
        return $res['rowCount'] > 0 && $res['id'] > 0 ? $res['id'] : null;
    }

    /**
     * Update a contract in the database
     * @param int $id id of the contract to update
     * @param string $vehicule_uid new contract's vehicule_uid
     * @param string $customer_uid new contract's customer_uid
     * @param string $sign_date new contract's sign_date
     * @param string|null $loc_begin_date new contract's loc_begin_date
     * @param string|null $loc_end_date new contract's loc_end_date
     * @param string|null $returning_date new contract's returning_date
     * @param float $price new contract's price
     * @return array
     */
    public function update(int $id, string $vehicule_uid, string $customer_uid, string $sign_date, ?string $loc_begin_date, ?string $loc_end_date, ?string $returning_date, float $price): bool {
        $loc_begin_date = !is_null($loc_begin_date) ? new DateTime($loc_begin_date) : null;
        $loc_end_date = !is_null($loc_end_date) ? new DateTime($loc_end_date) : null;
        $returning_date = !is_null($returning_date) ? new DateTime($returning_date) : null;
        return $this->repository->update($id, $vehicule_uid, $customer_uid, new DateTime($sign_date), $loc_begin_date, $loc_end_date, $returning_date, $price);
    }

    /**
     * Delete a contract in the database
     * @param int $id id of the contract to delete
     * @return bool
     */
    public function delete(int $id): bool {
        return $this->repository->delete($id);
    }
}