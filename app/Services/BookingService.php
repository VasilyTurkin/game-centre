<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Computer;
use App\Models\User;
use App\Services\ComputerAvailabilityService;
use App\Exceptions\ComputerNotAvailableException;
use App\Exceptions\FundsDepositException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Carbon\Carbon;

class BookingService
{
    private ComputerAvailabilityService $computerAvailabilityService;

    public function __construct(ComputerAvailabilityService $computerAvailabilityService)
    {
        $this->computerAvailabilityService = $computerAvailabilityService;
    }

    /**
     * Book computers for a user
     *
     * @param User $user
     * @param array $computers
     * @param string $startTime
     * @param int $duration
     * @return Booking
     *
     * @throws FundsDepositException
     * @throws ComputerNotAvailableException
     * @throws InvalidArgumentException
     */
    public function bookComputers(User $user, array $computers, string $startTime, int $duration): Booking
    {
        if (empty($computers)) {
            throw new InvalidArgumentException("Список компьютеров не может быть пустым.");
        }

        if ($duration <= 0) {
            throw new InvalidArgumentException("Длительность бронирования должна быть положительным числом.");
        }

        if (!$this->computerAvailabilityService->checkAvailable($computers, $startTime, $duration)) {
            throw new ComputerNotAvailableException();
        }

        // Рассчитываем общую стоимость
        $amount = collect($computers)->sum(function (Computer $computer) use ($duration) {
            return $computer->calculatePrice($duration);
        });

        return DB::transaction(function () use ($user, $computers, $startTime, $duration, $amount) {
            $user->pay($amount);

            $booking = Booking::create([
                'user_id' => $user->id,
                'start_time' => $startTime,
                'end_time' => $this->endTime($startTime, $duration),
            ]);

            $booking->computers()->attach(collect($computers)->pluck('id'));

            return $booking->load('computers');
        });
    }

    /**
     * Calculate end time based on start time and duration
     *
     * @param string $startTime
     * @param int $duration
     * @return string
     */
    public function endTime(string $startTime, int $duration): string
    {
        return Carbon::parse($startTime, 'Europe/Moscow')
            ->addHours($duration)
            ->toDateTimeString();
    }
}
