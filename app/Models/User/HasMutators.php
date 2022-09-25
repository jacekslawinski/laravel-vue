<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Support\Facades\Hash;

trait HasMutators
{
    /**
     *
     * @param string|null $value
     * @return void
     */
    public function setPasswordAttribute(?string $value): void
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
