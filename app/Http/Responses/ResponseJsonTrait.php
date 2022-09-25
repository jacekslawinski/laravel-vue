<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

trait ResponseJsonTrait
{
    /**
     *
     * @param ResponseInterface $response
     * @return JsonResponse
     */
    protected function runResponse(ResponseInterface $response): JsonResponse
    {
        return $response->handle();
    }
}
