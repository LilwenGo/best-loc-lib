<?php
namespace App\Tests;

use App\Repository\VehiculeRepository;
use MongoDB\BSON\ObjectId;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class VehiculeRepositoryTest extends TestCase {
    private VehiculeRepository $repository;

    public function setUp(): void {
        $this->repository = new VehiculeRepository();
    }

    public static function provideCreateData(): array {
        return [
            ['Golf', 'VolksWagen', 'BX-259-AN', "C'est une break à Lyon !!!", '130000'],
            ['EXPERT', 'Peugeot', 'TE2E75', 'Standard - Traction 1PL', '000005'],
            ['X', 'Tesla', 'R0SIB1F', 'Trop viiiite !!!', '123456']
        ];
    }

    #[DataProvider('provideCreateData')]
    public function testCreate(string $model, string $brand, string $licence_plate, string $informations, string $km): void {
        $res = $this->repository->create($model, $brand, $licence_plate, $informations, $km);
        $this->assertTrue($res['rowCount'] > 0);
        $this->assertIsObject($res['id']);
    }

    public static function provideFindData(): array {
        return [
            ['6762a8c218a2321f35003980', 'Golf', 'VolksWagen', 'BX-259-AN', "C'est une break à Lyon !!!", '130000'],
            ['6762a8c318a2321f35003983', 'EXPERT', 'Peugeot', 'TE2E75', 'Standard - Traction 1PL', '000005'],
            ['6762a8c318a2321f35003984', 'X', 'Tesla', 'R0SIB1F', 'Trop viiiite !!!', '123456']
        ];
    }

    #[DataProvider('provideFindData')]
    public function testFind(string $id, string $model, string $brand, string $licence_plate, string $informations, string $km): void {
        $res = $this->repository->find(new ObjectId($id));
        $this->assertTrue($res !== false, "Document couldn't be found !");
        $this->assertTrue(is_object($res) && get_class($res) === 'App\\Entity\\Vehicule', "Returned object is not of expected type !");
        $this->assertEquals($model, $res->getModel(), "Document's model has not the expected value !");
        $this->assertEquals($brand, $res->getBrand(), "Document's brand has not the expected value !");
        $this->assertEquals($licence_plate, $res->getLicence_plate(), "Document's licence_plate has not the expected value !");
        $this->assertEquals($informations, $res->getInformations(), "Document's informations has not the expected value !");
        $this->assertEquals($km, $res->getKm(), "Document's km has not the expected value !");
    }

    public static function provideUpdateData(): array {
        return [
            ['6762a99488513600be03da50', 'Golf', 'VolksWagen', 'BX-259-AN', "C'est une break à Lyon !!!", ''.time()],
            ['6762a99488513600be03da53', 'EXPERT', 'Peugeot', 'TE2E75', 'Standard - Traction 1PL', ''.time()],
            ['6762a99488513600be03da54', 'X', 'Tesla', 'R0SIB1F', 'Trop viiiite !!!', ''.time()]
        ];
    }

    #[DataProvider('provideUpdateData')]
    public function testUpdate(string $id, string $model, string $brand, string $licence_plate, string $informations, string $km): void {
        $res = $this->repository->update(new ObjectId($id), $model, $brand, $licence_plate, $informations, $km);
        $this->assertTrue($res, "Document couldn't be updated !");
    }

    public static function provideDeleteData(): array {
        return [
            ['6762bb555d1befebeb0e3080'],
            ['6762bb555d1befebeb0e3083'],
            ['6762bb555d1befebeb0e3084']
        ];
    }

    #[DataProvider('provideDeleteData')]
    public function testDelete(string $id): void {
        $res = $this->repository->delete(new ObjectId($id));
        $this->assertTrue($res, "Document couldn't be deleted !");
    }
}