<?php

declare(strict_types=1);

namespace App\Domains\System;

use App\Domains\AbstractOperation;
use App\Http\Responses\RespondNoContentJson;
use App\Http\Responses\RespondServerErrorJson;
use App\Models\System;
use App\Repositories\Interfaces\SystemRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class DeleteOperation extends AbstractOperation
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
            $this->systemRepository->delete($system);
            $response = new RespondNoContentJson('success');
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd usuwania systemu');
        }
        return $this->runResponse($response);
    }
}
