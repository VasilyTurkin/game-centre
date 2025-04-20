<?php

namespace App\Services;

use App\Repository\ComputerRepository;

class ComputerAvailabilityService
{
    private ComputerRepository $computerRepository;

    public function __construct(ComputerRepository $computerRepository)
    {
        $this->computerRepository = $computerRepository;
    }

    public function checkAvailable(array $computers, string $startTime, int $duration): bool
    {
        date_default_timezone_set("Europe/Moscow");

        $startTime = date('Y-m-d H:i:s', strtotime($startTime));
        $endTime = date('Y-m-d H:i:s', strtotime($startTime) + ($duration * 3600));

        $computersForPeriod = $this->computerRepository->findAvailableForPeriod($startTime, $endTime);

        $busyComputers = [];
        foreach ($computersForPeriod as $booking) {
            $busyComputers[] = $booking['computer_id'];
        }

        foreach ($computers as $computer) {
            if (!in_array($computer->getComputerId(), $busyComputers)) {
                return true;
            }
        }

        return false;
    }
}
