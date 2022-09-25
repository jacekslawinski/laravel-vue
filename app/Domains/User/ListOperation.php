<?php

declare(strict_types=1);

namespace App\Domains\User;

use App\Domains\AbstractOperation;
use App\Http\Responses\RespondServerErrorJson;
use App\Http\Responses\RespondSuccessJson;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class ListOperation extends AbstractOperation
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
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        try {
            $response = new RespondSuccessJson('success', $this->userRepository->list());
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd pobierania listy użytkowników');
        }
        return $this->runResponse($response);
    }
}
