<?php
namespace App\Entity;

use \DateTime;
class Contract {
    private int $id;
    private string $vehicule_uuid;
    private string $customer_uuid;
    private DateTime $sign_date;
    private DateTime $loc_begin_date;
    private DateTime $loc_end_date;
    private DateTime $returning_date;
    private float $price;

    public function getId(): int {
        return $this->id;
    }
    
    public function getVehicule_uuid(): string {
        return $this->vehicule_uuid;
    }
    
    public function getCustomer_uuid(): string {
        return $this->customer_uuid;
    }
    
    public function getSign_date(): DateTime {
        return $this->sign_date;
    }
    
    public function getLoc_begin_date(): DateTime {
        return $this->loc_begin_date;
    }
    
    public function getLoc_end_date(): DateTime {
        return $this->loc_end_date;
    }
    
    public function getReturning_date(): DateTime {
        return $this->returning_date;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }
    
    public function setVehicule_uuid(string $uuid): void {
        $this->vehicule_uuid = $uuid;
    }
    
    public function setCustomer_uuid(string $uuid): void {
        $this->customer_uuid = $uuid;
    }
    
    public function setSign_date(string $date): void {
        $this->sign_date = new DateTime($date);
    }
    
    public function setLoc_begin_date(string $date): void {
        $this->loc_begin_date = new DateTime($date);
    }
    
    public function setLoc_end_date(string $date): void {
        $this->loc_end_date = new DateTime($date);
    }
    
    public function setReturning_date(string $date): void {
        $this->returning_date = new DateTime($date);
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }
}