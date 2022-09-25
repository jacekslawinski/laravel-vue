<?php

declare(strict_types=1);

namespace App\Domains\Hardware;

use App\Domains\AbstractOperation;
use App\Http\Responses\RespondNoContentJson;
use App\Http\Responses\RespondServerErrorJson;
use App\Models\Hardware;
use App\Repositories\Interfaces\HardwareRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class DeleteOperation extends AbstractOperation
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
     * @param Hardware $hardware
     * @return JsonResponse
     */
    public function handle(Hardware $hardware): JsonResponse
    {
        try {
            $this->hardwareRepository->delete($hardware);
            $response = new RespondNoContentJson('success');
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd usuwania komputera');
        }
        return $this->runResponse($response);
    }
}
