<?php

declare(strict_types=1);

namespace App\Domains\System;

use App\Domains\AbstractOperation;
use App\Domains\System\Validators\StoreValidator;
use App\Http\Responses\RespondServerErrorJson;
use App\Http\Responses\RespondSuccessJson;
use App\Models\System;
use App\Repositories\Interfaces\SystemRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class UpdateOperation extends AbstractOperation
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
     * @param System $system
     * @return JsonResponse
     */
    public function handle(System $system): JsonResponse
    {
        try {
            $input = $this->requestData('name');
            $this->validateWithResponse(StoreValidator::class, $input);
            $response = new RespondSuccessJson('success', $this->systemRepository->update($system, $input));
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd dodawania systemu');
        }

        return $this->runResponse($response);
    }
}
