<?php

declare(strict_types=1);

namespace App\Domains;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\MessageBag;

abstract class AbstractInputValidator
{
    /**
     *
     * @var array $input
     */
    protected $input;

    /**
     *
     * @return array
     */
    abstract protected function rules(): array;

    /**
     *
     * @return array
     */
    abstract protected function messages(): array;

    /**
     *
     * @param array $input
     * @return MessageBag|null
     */
    public function validateInputFails(array $input): ?MessageBag
    {
        $this->input = $input;
        $factory = App::make(ValidationFactory::class);
        $validation = $factory->make($this->input, $this->rules(), $this->messages());
        return $validation->fails() ? $validation->errors() : null;
    }
}
