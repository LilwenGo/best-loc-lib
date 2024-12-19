<?php
namespace App\Repository;

use App\Database\MySQLConnexion;
use App\Entity\Contract;
use \DateTime;
use \PDO;

/**
 * This class interacts with the contract table of the MySQL database
 */
class ContractRepository {
    /**
     * Return the contract with matching id from database or false if not found
     * @param int $id id of the contract to find
     * @return Contract|false
     */
    public function find(int $id): Contract|false {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT * FROM contract WHERE id = ?");
        $stmt->execute([
            $id
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Contract::class);
        return $stmt->fetch();
    }

    /**
     * Return the contract with matching customer_uid from database or false if not found
     * @param string $customer_uid customer_uid of the contract to find
     * @return array
     */
    public function getByCustomer(string $customer_uid): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT * FROM contract WHERE customer_uid = ?");
        $stmt->execute([
            $customer_uid
        ]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contract::class);
    }

    /**
     * Return the contract with matching vehicule_uid from database or false if not found
     * @param string $vehicule_uid vehicule_uid of the contract to find
     * @return array
     */
    public function getByVehicule(string $vehicule_uid): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT * FROM contract WHERE vehicule_uid = ?");
        $stmt->execute([
            $vehicule_uid
        ]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contract::class);
    }

    /**
     * Return an array of all the contracts that have a returning_date that is later than loc_end_date of more than one hour
     * @return array
     */
    public function getLocLates(): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->query("SELECT * FROM (SELECT * FROM contract WHERE loc_begin_date IS NOT NULL) cl WHERE loc_begin_date IS NOT NULL AND TIMESTAMPDIFF(HOUR, loc_end_date, IFNULL(returning_date, NOW())) > 1");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contract::class);
    }

    /**
     * Return the count of all the contracts that have a returning_date that is later than loc_end_date of more than one hour between two dates
     * @param DateTime $date1 begining date
     * @param DateTime $date2 ending date
     * @return int
     */
    public function countLocLatesByDates(DateTime $date1, DateTime $date2): int {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT COUNT(*) AS total FROM (SELECT * FROM contract WHERE loc_begin_date IS NOT NULL) cl WHERE loc_begin_date IS NOT NULL AND TIMESTAMPDIFF(HOUR, loc_end_date, IFNULL(returning_date, NOW())) > 1 AND loc_end_date BETWEEN ? AND ?");
        $stmt->execute([
            $date1->format('Y-m-d H:i:s'),
            $date2->format('Y-m-d H:i:s')
        ]);
        $data = $stmt->fetch();
        return $data ? $data['total'] : 0;
    }
    
    /**
     * Return an array the counts of all the contracts, grouped by customer, that have a returning_date that is later than loc_end_date of more than one hour
     * @return array
     */
    public function countLocLatesPerCustomer(): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->query("SELECT customer_uid, COUNT(*) AS total FROM (SELECT * FROM contract WHERE loc_begin_date IS NOT NULL) cl WHERE loc_begin_date IS NOT NULL AND TIMESTAMPDIFF(HOUR, loc_end_date, IFNULL(returning_date, NOW())) > 1 GROUP BY customer_uid");
        return $stmt->fetchAll();
    }

    /**
     * Return an array of the curent contracts.
     * A curent contract has a defined loc_begin_date and an undefined returning_date
     * @param string $customer_uid
     * @return array
     */
    public function getCurrentLocations(string $customer_uid): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT * FROM contract WHERE customer_uid = ? AND loc_begin_date IS NOT NULL AND returning_date IS NULL");
        $stmt->execute([
            $customer_uid
        ]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contract::class);
    }

    /**
     * Return an array of all the contracts in the database
     * @return array
     */
    public function all(): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->query("SELECT * FROM contract");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contract::class);
    }

    /**
     * Return an array of all the contracts in the database sorted by customers
     * @return array
     */
    public function allSortedByCustomer(): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->query("SELECT * FROM contract ORDER BY customer_uid");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contract::class);
    }

    /**
     * Return an array of all the contracts in the database sorted by vehicules
     * @return array
     */
    public function allSortedByVehicule(): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->query("SELECT * FROM contract ORDER BY vehicule_uid");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contract::class);
    }

    /**
     * Insert a new contract in the database
     * @param string $vehicule_uid new contract's vehicule_uid
     * @param string $customer_uid new contract's customer_uid
     * @param DateTime $sign_date new contract's sign_date
     * @param DateTime|null $loc_begin_date new contract's loc_begin_date
     * @param DateTime|null $loc_end_date new contract's loc_end_date
     * @param DateTime|null $returning_date new contract's returning_date
     * @param float $price new contract's price
     * @return array
     */
    public function create(
        string $vehicule_uid, 
        string $customer_uid, 
        DateTime $sign_date, 
        ?DateTime $loc_begin_date, 
        ?DateTime $loc_end_date, 
        ?DateTime $returning_date, 
        float $price
    ): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("INSERT INTO contract(vehicule_uid, customer_uid, sign_date, loc_begin_date, loc_end_date, returning_date, price) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([
            $vehicule_uid,
            $customer_uid,
            $sign_date->format('Y-m-d H:i:s'),
            !is_null($loc_begin_date) ? $loc_begin_date->format('Y-m-d H:i:s') : null,
            !is_null($loc_end_date) ? $loc_end_date->format('Y-m-d H:i:s') : null,
            !is_null($returning_date) ? $returning_date->format('Y-m-d H:i:s') : null,
            $price
        ]);
        return [
            'id' => MySQLConnexion::getInstance()->getConnexion()->lastInsertId(),
            'rowCount' => $stmt->rowCount()
        ];
    }

    /**
     * Update a contract in the database
     * @param int $id id of the contract to update
     * @param string $vehicule_uid new contract's vehicule_uid
     * @param string $customer_uid new contract's customer_uid
     * @param DateTime $sign_date new contract's sign_date
     * @param DateTime|null $loc_begin_date new contract's loc_begin_date
     * @param DateTime|null $loc_end_date new contract's loc_end_date
     * @param DateTime|null $returning_date new contract's returning_date
     * @param float $price new contract's price
     * @return array
     */
    public function update(
        int $id,
        string $vehicule_uid, 
        string $customer_uid, 
        DateTime $sign_date, 
        ?DateTime $loc_begin_date, 
        ?DateTime $loc_end_date, 
        ?DateTime $returning_date, 
        float $price
    ): bool {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("UPDATE contract SET vehicule_uid = ?, customer_uid = ?, sign_date = ?, loc_begin_date = ?, loc_end_date = ?, returning_date = ?, price = ? WHERE id = ?");
        $stmt->execute([
            $vehicule_uid,
            $customer_uid,
            $sign_date->format('Y-m-d H:i:s'),
            !is_null($loc_begin_date) ? $loc_begin_date->format('Y-m-d H:i:s') : null,
            !is_null($loc_end_date) ? $loc_end_date->format('Y-m-d H:i:s') : null,
            !is_null($returning_date) ? $returning_date->format('Y-m-d H:i:s') : null,
            $price,
            $id
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Delete a contract from the database
     * @param int $id id of the contract to delete
     * @return bool
     */
    public function delete(int $id): bool {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("DELETE FROM contract WHERE id = ?");
        $stmt->execute([
            $id
        ]);
        return $stmt->rowCount() > 0;
    }
}