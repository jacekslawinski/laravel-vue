<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

interface ResponseInterface
{
    /**
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse;
}
