<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\System\DeleteOperation;
use App\Domains\System\ListOperation;
use App\Domains\System\StoreOperation;
use App\Domains\System\UpdateOperation;
use App\Models\System;
use Illuminate\Http\JsonResponse;

final class SystemController extends Controller
{
    /**
     *
     * @param ListOperation $listOperation
     * @return JsonResponse
     */
    public function index(ListOperation $listOperation): JsonResponse
    {
        return $listOperation->handle();
    }

    /**
     *
     * @param StoreOperation $storeOperation
     * @return JsonResponse
     */
    public function store(StoreOperation $storeOperation): JsonResponse
    {
        return $storeOperation->handle();
    }

    /**
     *
     * @param System $system
     * @param UpdateOperation $updateOperation
     * @return JsonResponse
     */
    public function update(System $system, UpdateOperation $updateOperation): JsonResponse
    {
        return $updateOperation->handle($system);
    }

    /**
     *
     * @param System $system
     * @param DeleteOperation $
     * @return JsonResponse
     */
    public function destroy(System $system, DeleteOperation $deleteOperation): JsonResponse
    {
        return $deleteOperation->handle($system);
    }
}
