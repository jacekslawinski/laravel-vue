<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\User\HasMutators;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $password
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property \DateTime $deleted_at
 */

final class User extends BaseModel
{
    use HasMutators;

    /**
     * @var string $table
     */
    protected $table = 'users';

    /**
     * @var array $dates
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
    ];

    /**
     *
     * @var array $hidden
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     *
     * @return HasOne
     */
    public function userHardwares(): HasMany
    {
        return $this->hasMany(UserHardware::class, 'user_id', 'id');
    }
}
