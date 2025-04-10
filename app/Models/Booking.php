<?php

namespace App\Models;

use DateTime;
use InvalidArgumentException;

class Booking
{
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELED = 'canceled';

    private User $user;
    private string $startTime;
    private string $endTime;
    private array $computers;
    private int $totalPrice;
    private string $status;

    public function __construct(User $user, array $computers, $startTime, $endTime)
    {
        if (empty($computers)) {
            throw new InvalidArgumentException("Массив компьютеров не должен быть пустым");
        }
        if (!DateTime::createFromFormat('Y-m-d H:i:s', $startTime)) {
            throw new InvalidArgumentException("Неверный формат времени. Ожидается: Y-m-d H:i:s");
        }

        $this->user = $user;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->computers = $computers;
        $this->totalPrice = self::setTotalPrice();
        $this->status = self::STATUS_CONFIRMED;
    }

    public function cancel(): void
    {
        $this->status = self::STATUS_CANCELED;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function setTotalPrice(): int
    {
        $totalPrice = 0;

        foreach ($this->computers as $computer) {
            $totalPrice += $computer->getComputerPrice();
        }
        return $this->totalPrice = $totalPrice;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getComputers(): array
    {
        return $this->computers;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
