<?php
namespace App\Entity;

use \DateTime;
class Contract {
    private int $id;
    private string $vehicule_uid;
    private string $customer_uid;
    private string $sign_date;
    private ?string $loc_begin_date;
    private ?string $loc_end_date;
    private ?string $returning_date;
    private float $price;

    public function getId(): int {
        return $this->id;
    }
    
    public function getVehicule_uid(): string {
        return $this->vehicule_uid;
    }
    
    public function getCustomer_uid(): string {
        return $this->customer_uid;
    }
    
    public function getSign_date(): DateTime {
        return new DateTime($this->sign_date);
    }
    
    public function getLoc_begin_date(): ?DateTime {
        return $this->loc_begin_date ? new DateTime($this->loc_begin_date) : null;
    }
    
    public function getLoc_end_date(): ?DateTime {
        return $this->loc_end_date ? new DateTime($this->loc_end_date) : null;
    }
    
    public function getReturning_date(): ?DateTime {
        return $this->returning_date ? new DateTime($this->returning_date) : null;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }
    
    public function setVehicule_uid(string $uid): void {
        $this->vehicule_uid = $uid;
    }
    
    public function setCustomer_uid(string $uid): void {
        $this->customer_uid = $uid;
    }
    
    public function setSign_date(DateTime|string $date): void {
        if(is_object($date)) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->sign_date = $date;
    }
    
    public function setLoc_begin_date(DateTime|string|null $date): void {
        if(is_object($date)) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->loc_begin_date = $date;
    }
    
    public function setLoc_end_date(DateTime|string|null $date): void {
        if(is_object($date)) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->loc_end_date = $date;
    }
    
    public function setReturning_date(DateTime|string|null $date): void {
        if(is_object($date)) {
            $date = $date->format('Y-m-d H:i:s');
        }
        $this->returning_date = $date;
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }
}