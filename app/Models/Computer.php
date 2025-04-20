<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $price
 * @property string $specs
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class Computer extends Model
{
    /** @use HasFactory<\Database\Factories\ComputerFactory> */
    use HasFactory;

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
    protected $table = 'computers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'specs'
    ];
    /**
     * Calculate price for  booking computers
     *
     * @param int|string $duration
     * @return int
     */
    public function calculatePrice(int|string $duration): int
    {
        return $this->price * (int)$duration;
    }
}
