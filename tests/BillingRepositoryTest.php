<?php
namespace BestLocLib\Tests;

use BestLocLib\Database\MySQLConnexion;
use BestLocLib\Repository\BillingRepository;
use BestLocLib\Repository\CustomerRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class BillingRepositoryTest extends TestCase {
    private static BillingRepository $repository;

    public static function setUpBeforeClass(): void {
        self::$repository = new BillingRepository();
        MySQLConnexion::getInstance()->getConnexion()->beginTransaction();
    }

    public static function tearDownAfterClass(): void {
        MySQLConnexion::getInstance()->getConnexion()->rollBack();
    }

    public static function provideFindData(): array {
        return [
            [1, 11.25],
            [2, 12.50],
            [3, 13.75]
        ];
    }

    #[DataProvider('provideFindData')]
    public function testFind(int $id, float $expected): void {
        $res = self::$repository->find($id);
        $this->assertNotNull($res, "Method find does not return the expected result !");
        $this->assertEquals($expected, $res->getAmount(), "Method find returned unexpected object values !");
    }

    public function testAll(): void {
        $res = self::$repository->all();
        $this->assertNotEmpty($res, "Method all does not return results !");
    }

    public static function provideCreateData(): array {
        return [
            [1, 14],
            [1, 15.25],
            [1, 16.5]
        ];
    }
    
    #[DataProvider('provideCreateData')]
    public function testCreate(int $contract_id, float $amount): void {
        $res = self::$repository->create($contract_id, $amount);
        $this->assertTrue($res['id'] > 0 && $res['rowCount'] > 0, "Method create has not insert the line !");
    }

    public static function provideUpdateData(): array {
        return [
            [1, 1, 10.25],
            [2, 1, 11.5],
            [3, 1, 12.75]
        ];
    }
    
    #[DataProvider('provideUpdateData')]
    public function testUpdate(int $id, int $contract_id, float $amount): void {
        $res = self::$repository->update($id, $contract_id, $amount);
        $this->assertTrue($res, "Method update has not updated the line !");
    }

    public static function provideDeleteData(): array {
        return [
            [4],
            [5],
            [6]
        ];
    }
    
    #[DataProvider('provideDeleteData')]
    public function testDelete(int $id): void {
        $res = self::$repository->delete($id);
        $this->assertTrue($res, "Method delete has not deleted the line !");
    }
}