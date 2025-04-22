<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InvalidArgumentException;
use Carbon\Carbon;

/**
 * @property string $status
 */
class Booking extends Model
{
    use HasFactory;

    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELED = 'canceled';

    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'totalPrice',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_price' => 'integer',
    ];

    protected $attributes = [
        'status' => self::STATUS_CONFIRMED,
    ];

    /**
     *
     * Create a new booking.
     *
     * @param array $attributes
     * @throws InvalidArgumentException
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (isset($attributes['computers']) && empty($attributes['computers'])) {
            throw new InvalidArgumentException("Массив компьютеров не должен быть пустым");
        }
    }

    /**
     * Cancel the booking.
     */
    public function cancel(): void
    {
        $this->status = self::STATUS_CANCELED;
        $this->save();
    }

    /**
     * Calculate and set the total price for the booking.
     */
    public function calculateTotalPrice(): int
    {
        $totalPrice = $this->computers->sum('price');
        $this->total_price = $totalPrice;
        return $totalPrice;
    }

    /**
     * Get the user that owns the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the computers for the booking.
     */
    public function computers(): BelongsToMany
    {
        return $this->belongsToMany(Computer::class, 'booking_computer');
    }

    /**
     * Set the start time attribute.
     */
    public function setStartTimeAttribute($value): void
    {
        $this->attributes['start_time'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * Set the end time attribute.
     */
    public function setEndTimeAttribute($value): void
    {
        $this->attributes['end_time'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
