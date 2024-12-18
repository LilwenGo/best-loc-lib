<?php
namespace App\Tests;

use App\Repository\ContractRepository;
use App\Database\MySQLConnexion;
use DateInterval;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use \DateTime;

final class ContractRepositoryTest extends TestCase {
    private static ContractRepository $repository;

    public static function setUpBeforeClass(): void {
        self::$repository = new ContractRepository();
        MySQLConnexion::getInstance()->getConnexion()->beginTransaction();
    }

    public static function tearDownAfterClass(): void {
        MySQLConnexion::getInstance()->getConnexion()->rollBack();
    }

    public static function provideFindData(): array {
        return [
            [1, 'azertyuiop', 'azertyuiop', 11.25],
            [2, 'azertyuiop', 'azertyuiop', 12.50],
            [3, 'azertyuiop', 'azertyuiop', 13.75]
        ];
    }

    #[DataProvider('provideFindData')]
    public function testFind(int $id, string $customer_uid, string $vehicule_uid, float $price): void {
        $res = self::$repository->find($id);
        $this->assertNotNull($res, "Method find does not return the expected result !");
        $this->assertEquals($customer_uid, $res->getCustomer_uid(), "Method find returned unexpected object values !");
        $this->assertEquals($vehicule_uid, $res->getVehicule_uid(), "Method find returned unexpected object values !");
        $this->assertEquals($price, $res->getPrice(), "Method find returned unexpected object values !");
    }

    public static function provideCreateData(): array {
        return [
            ['azertyuiop', 'azertyuiop', 11.25],
            ['azertyuiop', 'azertyuiop', 12.50],
            ['azertyuiop', 'azertyuiop', 13.75]
        ];
    }

    #[DataProvider('provideCreateData')]
    public function testCreate(string $customer_uid, string $vehicule_uid, float $price): void {
        $res = self::$repository->create($vehicule_uid, $customer_uid, new DateTime(), new DateTime(), new DateTime(), new DateTime(), $price);
        $this->assertTrue($res['rowCount'] > 0 && $res['id'] > 0, "Method create does not insert the line !");
    }

    public static function provideUpdateData(): array {
        return [
            [10, 'azertyuiop', 'azertyuiop', 11.5],
            [11, 'azertyuiop', 'azertyuiop', 12.75],
            [12, 'azertyuiop', 'azertyuiop', 13.0]
        ];
    }

    #[DataProvider('provideUpdateData')]
    public function testUpdate(int $id, string $customer_uid, string $vehicule_uid, float $price): void {
        $res = self::$repository->update($id, $vehicule_uid, $customer_uid, new DateTime(), new DateTime(), new DateTime(), new DateTime(), $price);
        $this->assertTrue($res, "Method update does not updated the line !");
    }

    public static function provideDeleteData(): array {
        return [
            [13],
            [14],
            [15]
        ];
    }

    #[DataProvider('provideDeleteData')]
    public function testDelete(int $id): void {
        $res = self::$repository->delete($id);
        $this->assertTrue($res, "Method delete does not deleted the line !");
    }
}