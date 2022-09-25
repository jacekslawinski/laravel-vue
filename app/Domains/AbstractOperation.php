<?php

declare(strict_types=1);

namespace App\Domains;

use App\Exceptions\ValidationException;
use App\Http\Responses\ResponseJsonTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

abstract class AbstractOperation
{
    use ResponseJsonTrait;

    /**
     *
     * @param string $validatorClass
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    protected function validateWithResponse(string $validatorClass, array $data): void
    {
        $validator = App::build($validatorClass);
        if ($errors = $validator->validateInputFails($data)) {
            throw new ValidationException($errors->toArray());
        }
    }

    /**
     *
     * @param array|string $keys
     * @return array
     */
    protected function requestData(array|string $keys): array
    {
        return Arr::only(request()->all(), $keys);
    }
}
