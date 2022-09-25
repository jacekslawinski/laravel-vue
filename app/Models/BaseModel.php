<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        $serializedModel = parent::toArray();
        $camelSerializedModel = array();
        foreach ($serializedModel as $name => $value) {
            $camelSerializedModel[Str::camel($name)] = $value;
        }
        return $camelSerializedModel;
    }
}
