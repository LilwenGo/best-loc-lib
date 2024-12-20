<?php
namespace BestLocLib\Entity;

class Billing {
    private int $id;
    private int $contract_id;
    private float $amount;

    public function getId(): int {
        return $this->id;
    }
    public function getContract_id(): int {
        return $this->contract_id;
    }
    public function getAmount(): float {
        return $this->amount;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setContract_id(int $id): void {
        $this->contract_id = $id;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }
}