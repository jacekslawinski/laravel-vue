<?php

declare(strict_types=1);

namespace App\Domains\User\Validators;

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
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email',
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
