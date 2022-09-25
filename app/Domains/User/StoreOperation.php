<?php

declare(strict_types=1);

namespace App\Domains\User;

use App\Domains\AbstractOperation;
use App\Domains\User\Validators\StoreValidator;
use App\Http\Responses\RespondServerErrorJson;
use App\Http\Responses\RespondSuccessJson;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class StoreOperation extends AbstractOperation
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
            $input = $this->requestData(
                [
                    'firstname',
                    'lastname',
                    'email',
                ]
            );
            $this->validateWithResponse(StoreValidator::class, $input);
            $response = new RespondSuccessJson('success', $this->userRepository->store($input));
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd dodawania użytkownika');
        }
        return $this->runResponse($response);
    }
}
