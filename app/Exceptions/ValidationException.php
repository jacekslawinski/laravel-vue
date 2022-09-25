<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    /**
     *
     * @param array $errors, default: []
     */
    public function __construct(
        private array $errors = []
    ) {
    }

    /**
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
