<?php

namespace App\Models;

class ComputerOld
{
    private int $id;
    private string $name;
    private int $price;
    private string $specs;

    public function __construct(array $computerData)
    {
        $this->id = $computerData['id'];
        $this->name = $computerData['name'];
        $this->price = $computerData['price'];
        $this->specs = $computerData['specs'];
    }

    public function calculatePrice(int|string $duration): int
    {
        return $this->getComputerPrice() * $duration;
    }

    public function getComputerId(): int
    {
        return $this->id;
    }

    public function getComputerName(): string
    {
        return $this->name;
    }

    public function getComputerPrice(): int
    {
        return $this->price;
    }

    public function getComputerSpecs(): string
    {
        return $this->specs;
    }
}
