<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Exceptions\DepositLimitException;
use App\Exceptions\FundsDepositException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * // Описать поля
 * @property int $deposit
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
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
        $this->save();
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
    }

    public function bookings():HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
