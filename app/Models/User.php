<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exception\DepositLimitException;
use App\Exception\FundsDepositException;

/**
 * @property int $deposit
 */
class User extends Model
{
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
        'login',
        'email',
        'userName',
        'password',
        'deposit'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

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
