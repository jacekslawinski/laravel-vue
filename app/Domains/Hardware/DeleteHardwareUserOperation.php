<?php

declare(strict_types=1);

namespace App\Domains\Hardware;

use App\Domains\AbstractOperation;
use App\Http\Responses\RespondNoContentJson;
use App\Http\Responses\RespondServerErrorJson;
use App\Models\Hardware;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class DeleteHardwareUserOperation extends AbstractOperation
{
    /**
     *
     * @param Hardware $hardware
     * @return JsonResponse
     */
    public function handle(Hardware $hardware): JsonResponse
    {
        try {
            $hardware->userHardware()->delete();
            $response = new RespondNoContentJson('success');
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd usuwania relacji');
        }
        return $this->runResponse($response);
    }
}
