<?php

declare(strict_types=1);

namespace App\Domains\Hardware\Validators;

use App\Domains\AbstractInputValidator;

final class StoreValidator extends AbstractInputValidator
{
    /**
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'system_id' => 'nullable|int',
            'name' => 'required|string|max:100',
            'serial_number' => 'required|string|max:100',
            'production_month' => 'required',
        ];
    }

    /**
     *
     * @return array
     */
    protected function messages(): array
    {
        return [];
    }
}
