<?php

declare(strict_types=1);

namespace App\Domains\User\Validators;

use App\Domains\AbstractInputValidator;

final class UpdateValidator extends AbstractInputValidator
{
    /**
     *
     * @return array
     */
    protected function rules(): array
    {
        $currentUser = request()->route('user');
        return [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $currentUser->id
            ],
        ];
    }

    /**
     *
     * @return array
     */
    protected function messages(): array
    {
        return [
            'firstname.required' => 'Firstname jest wymagane',
            'firstname.max' => 'Firstname jest zbyt długie (max. 50 znaków)',
            'lastname.required' => 'Lastname jest wymagane',
            'lastname.max' => 'Lastname jest zbyt długie (max. 50 znaków)',
            'email.required' => 'Email jest wymagany',
            'email.email' => 'To nie jest prawidłowy adres email',
            'email.max' => 'Email jest zbyt długi (max. 255 znaków)',
            'email.unique' => 'Taki email już istnieje',
        ];
    }
}
