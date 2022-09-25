<?php

declare(strict_types=1);

namespace App\Domains\System\Validators;

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
            'name' => 'required|string|max:100',
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
