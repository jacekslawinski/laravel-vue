<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\User\DeleteOperation;
use App\Domains\User\ListOperation;
use App\Domains\User\StoreOperation;
use App\Domains\User\UpdateOperation;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class UserController extends Controller
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
     * @param User $user
     * @param UpdateOperation $updateOperation
     * @return JsonResponse
     */
    public function update(User $user, UpdateOperation $updateOperation): JsonResponse
    {
        return $updateOperation->handle($user);
    }

    /**
     *
     * @param User $user
     * @param DeleteOperation $deleteOperation
     * @return JsonResponse
     */
    public function destroy(User $user, DeleteOperation $deleteOperation): JsonResponse
    {
        return $deleteOperation->handle($user);
    }
}
