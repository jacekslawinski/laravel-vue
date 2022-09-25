<?php

declare(strict_types=1);

namespace App\Domains\Hardware;

use App\Domains\AbstractOperation;
use App\Domains\Hardware\Validators\StoreValidator;
use App\Http\Responses\RespondServerErrorJson;
use App\Http\Responses\RespondSuccessJson;
use App\Models\Hardware;
use App\Repositories\Interfaces\HardwareRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class UpdateOperation extends AbstractOperation
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
            $input = $this->requestData(
                [
                    'system_id',
                    'name',
                    'serial_number',
                    'production_month',
                ]
            );
            $this->validateWithResponse(StoreValidator::class, $input);
            $response = new RespondSuccessJson('success', $this->hardwareRepository->update($hardware, $input));
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd dodawania hardware');
        }
        return $this->runResponse($response);
    }
}
