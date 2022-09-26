<?php

declare(strict_types=1);

namespace App\Domains\User;

use App\Domains\AbstractOperation;
use App\Http\Responses\RespondNoContentJson;
use App\Http\Responses\RespondServerErrorJson;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class DeleteOperation extends AbstractOperation
{
    /**
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     *
     * @param User $user
     * @return JsonResponse
     */
    public function handle(User $user): JsonResponse
    {
        try {
            $this->userRepository->delete($user);
            $response = new RespondNoContentJson('success');
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd usuwania user');
        }

        return $this->runResponse($response);
    }
}
