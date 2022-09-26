<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Hardware
 *
 * @property int $id
 * @property string $name
 * @property string $serial_number
 * @property string $production_month
 * @property int $system_id
 * @property \DateTime $deleted_at
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */

final class Hardware extends BaseModel
{
    /**
     * @var string $table
     */
    protected $table = 'hardwares';

    /**
     *
     * @var array $attributes
     */
    protected $attributes = [
        'id' => null,
        'name' => null,
        'serial_number' => null,
        'production_month' => null,
        'system_id' => null
    ];

    /**
     * @var array $dates
     */
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array<string> $fillable
     */
    protected $fillable = [
        'name',
        'serial_number',
        'production_month',
        'system_id'
    ];

    /**
     * @var array<string> $hidden
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     *
     * @return HasOne
     */
    public function userHardware(): HasOne
    {
        return $this->hasOne(UserHardware::class, 'hardware_id', 'id');
    }
}
