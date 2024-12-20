<?php
namespace BestLocLib\Repository;

use BestLocLib\Database\MySQLConnexion;
use BestLocLib\Entity\Billing;
use \PDO;

/**
 * This class interacts with the billing table of the MySQL database
 */
class BillingRepository {
    /**
     * Return the billing with matching id or false if not found
     * @param int $id id of the billing to find
     * @return Billing|false
     */
    public function find(int $id): Billing|false {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT * FROM billing WHERE id = ?");
        $stmt->execute([
            $id
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Billing::class);
        return $stmt->fetch();
    }

    /**
     * Return an array of billings with matching contract_id
     * @param int $contract_id contract_id to match
     * @return array
     */
    public function getByContract(int $contract_id): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT * FROM billing WHERE contract_id = ?");
        $stmt->execute([
            $contract_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Billing::class);
    }

    /**
     * Return an array of all the billings from database
     * @return array
     */
    public function all(): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->query("SELECT * FROM billing");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Billing::class);
    }

    /**
     * Insert a new billing in the database
     * @param int $contract_id new billing's contract_id
     * @param float $amount new billing's amount
     * @return array
     */
    public function create(int $contract_id, float $amount): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("INSERT INTO billing(contract_id, amount) VALUES (?,?)");
        $stmt->execute([
            $contract_id,
            $amount
        ]);
        return [
            'id' => MySQLConnexion::getInstance()->getConnexion()->lastInsertId(),
            'rowCount' => $stmt->rowCount()
        ];
    }

    /**
     * Update a billing in the database
     * @param int $id id of the billing to update
     * @param int $contract_id new billing's contract_id
     * @param float $amount new billing's amount
     * @return array
     */
    public function update(int $id, int $contract_id, float $amount): bool {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("UPDATE billing SET contract_id = ?, amount = ? WHERE id = ?");
        $stmt->execute([
            $contract_id,
            $amount,
            $id
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Delete the matching billing from database
     * @param int $id id of the billing to delete
     * @return bool
     */
    public function delete(int $id): bool {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("DELETE FROM billing WHERE id = ?");
        $stmt->execute([
            $id
        ]);
        return $stmt->rowCount() > 0;
    }
}