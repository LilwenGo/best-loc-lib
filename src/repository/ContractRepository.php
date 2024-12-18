<?php
namespace App\Repository;

use App\Database\MySQLConnexion;
use App\Entity\Contract;
use \DateTime;
use \PDO;

class ContractRepository {
    public function find(int $id): Contract|false {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("SELECT * FROM contract WHERE id = ?");
        $stmt->execute([
            $id
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Contract::class);
        return $stmt->fetch();
    }

    public function all(): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->query("SELECT * FROM contract");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Contract::class);
    }

    public function create(
        string $vehicule_uid, 
        string $customer_uid, 
        DateTime $sign_date, 
        DateTime $loc_begin_date, 
        DateTime $loc_end_date, 
        DateTime $returning_date, 
        float $price
    ): array {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("INSERT INTO contract(vehicule_uid, customer_uid, sign_date, loc_begin_date, loc_end_date, returning_date, price) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([
            $vehicule_uid,
            $customer_uid,
            $sign_date->format('Y-m-d H:i:s'),
            $loc_begin_date->format('Y-m-d H:i:s'),
            $loc_end_date->format('Y-m-d H:i:s'),
            $returning_date->format('Y-m-d H:i:s'),
            $price
        ]);
        return [
            'id' => MySQLConnexion::getInstance()->getConnexion()->lastInsertId(),
            'rowCount' => $stmt->rowCount()
        ];
    }

    public function update(
        int $id,
        string $vehicule_uid, 
        string $customer_uid, 
        DateTime $sign_date, 
        DateTime $loc_begin_date, 
        DateTime $loc_end_date, 
        DateTime $returning_date, 
        float $price
    ): bool {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("UPDATE contract SET vehicule_uid = ?, customer_uid = ?, sign_date = ?, loc_begin_date = ?, loc_end_date = ?, returning_date = ?, price = ? WHERE id = ?");
        $stmt->execute([
            $vehicule_uid,
            $customer_uid,
            $sign_date->format('Y-m-d H:i:s'),
            $loc_begin_date->format('Y-m-d H:i:s'),
            $loc_end_date->format('Y-m-d H:i:s'),
            $returning_date->format('Y-m-d H:i:s'),
            $price,
            $id
        ]);
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool {
        $stmt = MySQLConnexion::getInstance()->getConnexion()->prepare("DELETE FROM contract WHERE id = ?");
        $stmt->execute([
            $id
        ]);
        return $stmt->rowCount() > 0;
    }
}