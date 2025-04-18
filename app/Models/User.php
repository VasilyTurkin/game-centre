<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Exception\DepositLimitException;
use App\Exception\FundsDepositException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property int $deposit
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const MAX_DEPOSIT = 10000;

    /**
     * Db connection
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'deposit'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function cancelBooking(BookingOld $booking): void
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
        $this->save();

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

        $this->deposit -= $amount;
        $this->save();

        echo "Оплата прошла успешно. Остаток на депозите: $this->deposit" . PHP_EOL;
    }
}
