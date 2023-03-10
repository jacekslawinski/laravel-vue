<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{

    public static function boot()
    {
        parent::boot();
        static::saving(fn($model) => config('database.can_write'));
        static::deleting(fn($model) => config('database.can_write'));
    }
}
