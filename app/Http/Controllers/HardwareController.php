<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Hardware\AddHardwareUserOperation;
use App\Domains\Hardware\DeleteHardwareUserOperation;
use App\Domains\Hardware\DeleteOperation;
use App\Domains\Hardware\ListOperation;
use App\Domains\Hardware\StoreOperation;
use App\Domains\Hardware\UpdateOperation;
use App\Models\Hardware;
use Illuminate\Http\JsonResponse;

final class HardwareController extends Controller
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
     * @param Hardware $hardware
     * @param UpdateOperation $updateOperation
     * @return JsonResponse
     */
    public function update(Hardware $hardware, UpdateOperation $updateOperation): JsonResponse
    {
        return $updateOperation->handle($hardware);
    }

    /**
     *
     * @param Hardware $hardware
     * @param DeleteOperation $deleteOperation
     * @return JsonResponse
     */
    public function destroy(Hardware $hardware, DeleteOperation $deleteOperation): JsonResponse
    {
        return $deleteOperation->handle($hardware);
    }

    /**
     *
     * @param Hardware $hardware
     * @param DeleteHardwareUserOperation $deleteHardwareUserOperation
     * @return JsonResponse
     */
    public function deleteUserHardware(
        Hardware $hardware,
        DeleteHardwareUserOperation $deleteHardwareUserOperation
    ): JsonResponse {
        return $deleteHardwareUserOperation->handle($hardware);
    }

    /**
     *
     * @param Hardware $hardware
     * @param AddHardwareUserOperation $addHardwareUserOperation
     * @return JsonResponse
     */
    public function addUserHardware(
        Hardware $hardware,
        AddHardwareUserOperation $addHardwareUserOperation
    ): JsonResponse {
        return $addHardwareUserOperation->handle($hardware);
    }
}
