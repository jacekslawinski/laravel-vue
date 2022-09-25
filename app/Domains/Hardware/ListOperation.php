<?php

declare(strict_types=1);

namespace App\Domains\Hardware;

use App\Domains\AbstractOperation;
use App\Http\Responses\RespondServerErrorJson;
use App\Http\Responses\RespondSuccessJson;
use App\Repositories\Interfaces\HardwareRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class ListOperation extends AbstractOperation
{
    /**
     *
     * @param HardwareRepositoryInterface $hardwareRepository
     */
    public function __construct(
        private HardwareRepositoryInterface $hardwareRepository
    ) {
    }

    /**
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        try {
            $response = new RespondSuccessJson('success', $this->hardwareRepository->list());
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd pobierania listy');
        }
        return $this->runResponse($response);
    }
}
