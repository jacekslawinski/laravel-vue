<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Hardware;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\UserHardware
 *
 * @property int $user_id*
 * @property int $hardware_id
 */

final class UserHardware extends BaseModel
{
    /**
     *
     * @var boolean $timestamps
     */
    public $timestamps = false;

    /**
     *
     * @var boolean $incrementing
     */
    public $incrementing = false;

    /**
     * @var string $table
     */
    protected $table = 'user_hardwares';

    /**
     * @var array<string> $fillable
     */
    protected $fillable = [
        'user_id',
        'hardware_id',
    ];

    /**
     * @var array<string> $hidden
     */
    protected $hidden = [
        'user_id',
        'hardware_id',
    ];

    /**
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

        /**
     *
     * @return HasOne
     */
    public function hardware(): HasOne
    {
        return $this->hasOne(Hardware::class, 'id', 'hardware_id');
    }
}
