<?php

namespace App\Models;

use App\Exception\DepositLimitException;
use App\Exception\FundsDepositException;

class User
{
    const MAX_DEPOSIT = 10000;

    private int $user_id;
    private string $login;
    private string $email;
    private string $userName;
    private string $passwordHash;
    private int $deposit;

    public function __construct(array $userData)
    {
        $this->user_id = $userData['user_id'];
        $this->login = $userData['login'];
        $this->email = $userData['email'];
        $this->userName = $userData['userName'];
        $this->passwordHash = $userData['password'];
        $this->deposit = $userData['deposit'];
    }

    public function cancelBooking(Booking $booking): void
    {
        $booking->cancel();
    }

    /**
     * @throws DepositLimitException
     */
    public function addDeposit(int $amount): void
    {
        $limit = self::MAX_DEPOSIT - $this->deposit;

        if ($amount > $limit) {
            throw new DepositLimitException($limit);
        }

        $this->deposit += $amount;
        echo "Депозит пополнен. Сумма депозита: $this->deposit" . PHP_EOL;
    }

    /**
     * @throws FundsDepositException
     */
    public function pay(int $amount): void
    {
        if ($this->deposit < $amount) {
            throw new FundsDepositException();
        }

        $this->deposit = $this->deposit - $amount;
        echo "Оплата прошла успешно. Остаток на депозите: $this->deposit" . PHP_EOL;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->userName;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getDeposit(): int
    {
        return $this->deposit;
    }
}
