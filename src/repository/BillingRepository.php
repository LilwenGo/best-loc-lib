<?php
namespace App\Repository;

use App\Database\MySQLConnexion;
use App\Entity\Billing;
use \PDO;

class BillingRepository {
    public function find(int $id): Billing|false {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT * FROM billing WHERE id = ?");
        $stmt->execute([
            $id
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Billing::class);
        return $stmt->fetch();
    }

    public function getByContract(int $contract_id): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT * FROM billing WHERE contract_id = ?");
        $stmt->execute([
            $contract_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Billing::class);
    }

    public function all(): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->query("SELECT * FROM billing");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Billing::class);
    }

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

    public function update(int $id, int $contract_id, float $amount): bool {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("UPDATE billing SET contract_id = ?, amount = ? WHERE id = ?");
        $stmt->execute([
            $contract_id,
            $amount,
            $id
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("DELETE FROM billing WHERE id = ?");
        $stmt->execute([
            $id
        ]);
        return $stmt->rowCount() > 0;
    }
}