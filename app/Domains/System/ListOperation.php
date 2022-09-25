<?php

declare(strict_types=1);

namespace App\Domains\System;

use App\Domains\AbstractOperation;
use App\Http\Responses\RespondServerErrorJson;
use App\Http\Responses\RespondSuccessJson;
use App\Repositories\Interfaces\SystemRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class ListOperation extends AbstractOperation
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
            $response = new RespondSuccessJson('success', $this->systemRepository->list());
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd pobierania listy systemów');
        }
        return $this->runResponse($response);
    }
}
