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
        static::saving(function($model) {
            return config('database.can_write');
        });
    }
}
