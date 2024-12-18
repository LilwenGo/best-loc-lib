<?php
namespace App\Tests;

use App\Repository\CustomerRepository;
use MongoDB\BSON\ObjectId;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CustomerRepositoryTest extends TestCase {
    private CustomerRepository $repository;

    public function setUp(): void {
        $this->repository = new CustomerRepository();
    }

    public static function provideCreateData(): array {
        return [
            ['Lilian', 'Ortega', '4 rue Casimir Périer', 'lilian@areastudio.fr', 'motdepassetrèscompliqué', '00000000'],
            ['Ethan', 'Paleyron', 'Très loin', 'epayleyron@edenschool.fr', 'motdepassetrèscompliqué', '00000001'],
            ['Joshua', 'Jorge-Beau', 'Moins loin', 'jjorgebeau.pro@gmail.com', 'motdepassetrèscompliqué', '00000002']
        ];
    }

    #[DataProvider('provideCreateData')]
    public function testCreate(string $first_name, string $last_name, string $address, string $email, string $password, string $permit_number): void {
        $res = $this->repository->create($first_name, $last_name, $address, $email, $password, $permit_number);
        $this->assertTrue($res['rowCount'] > 0);
        $this->assertIsObject($res['id']);
    }

    public static function provideFindData(): array {
        return [
            ['67628a98f70f8304660363c0', 'Lilian', 'Ortega', '4 rue Casimir Périer', 'lilian@areastudio.fr', 'motdepassetrèscompliqué', '00000000'],
            ['67628a98f70f8304660363c3', 'Ethan', 'Paleyron', 'Très loin', 'epayleyron@edenschool.fr', 'motdepassetrèscompliqué', '00000001'],
            ['67628a98f70f8304660363c4', 'Joshua', 'Jorge-Beau', 'Moins loin', 'jjorgebeau.pro@gmail.com', 'motdepassetrèscompliqué', '00000002']
        ];
    }

    #[DataProvider('provideFindData')]
    public function testFind(string $id, string $first_name, string $last_name, string $address, string $email, string $password, string $permit_number): void {
        $res = $this->repository->find(new ObjectId($id));
        $this->assertTrue($res !== false, "Document couldn't be found !");
        $this->assertTrue(is_object($res) && get_class($res) === 'App\\Entity\\Customer', "Returned object is not of expected type !");
        $this->assertEquals($first_name, $res->getFirstName(), "Document's first name has not the expected value !");
        $this->assertEquals($last_name, $res->getLastName(), "Document's last name has not the expected value !");
        $this->assertEquals($address, $res->getAddress(), "Document's address has not the expected value !");
        $this->assertEquals($email, $res->getEmail(), "Document's email has not the expected value !");
        $this->assertEquals($password, $res->getPassword(), "Document's password has not the expected value !");
        $this->assertEquals($permit_number, $res->getPermitNumber(), "Document's permit_number has not the expected value !");
    }

    public static function provideUpdateData(): array {
        return [
            ['67628a98f70f8304660363c0', 'Lilian', 'Ortega', '4 rue Casimir Périer', 'lilian@areastudio.fr', 'motdepasse'.time(), '00000000'],
            ['67628a98f70f8304660363c3', 'Ethan', 'Paleyron', 'Très loin', 'epayleyron@edenschool.fr', 'motdepasse'.time(), '00000001'],
            ['67628a98f70f8304660363c4', 'Joshua', 'Jorge-Beau', 'Moins loin', 'jjorgebeau.pro@gmail.com', 'motdepasse'.time(), '00000002']
        ];
    }

    #[DataProvider('provideUpdateData')]
    public function testUpdate(string $id, string $first_name, string $last_name, string $address, string $email, string $password, string $permit_number): void {
        $res = $this->repository->update(new ObjectId($id), $first_name, $last_name, $address, $email, $password, $permit_number);
        $this->assertTrue($res, "Document couldn't be updated !");
    }

    public static function provideDeleteData(): array {
        return [
            ['6762909f4c12e7c941078a50'],
            ['6762909f4c12e7c941078a53'],
            ['6762909f4c12e7c941078a54']
        ];
    }

    #[DataProvider('provideDeleteData')]
    public function testDelete(string $id): void {
        $res = $this->repository->delete(new ObjectId($id));
        $this->assertTrue($res, "Document couldn't be deleted !");
    }
}