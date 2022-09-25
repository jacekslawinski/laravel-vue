<?php

declare(strict_types=1);

namespace App\Domains\System;

use App\Domains\AbstractOperation;
use App\Domains\System\Validators\StoreValidator;
use App\Http\Responses\RespondServerErrorJson;
use App\Http\Responses\RespondSuccessJson;
use App\Repositories\Interfaces\SystemRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class StoreOperation extends AbstractOperation
{
    /**
     *
     * @param SystemRepositoryInterface $systemRepository
     */
    public function __construct(
        private SystemRepositoryInterface $systemRepository
    ) {
    }

    /**
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        try {
            $input = $this->requestData('name');
            $this->validateWithResponse(StoreValidator::class, $input);
            $response = new RespondSuccessJson('success', $this->systemRepository->store($input));
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd dodawania system');
        }
        return $this->runResponse($response);
    }
}
