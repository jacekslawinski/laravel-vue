<?php

declare(strict_types=1);

namespace App\Domains\User;

use App\Domains\AbstractOperation;
use App\Domains\User\Validators\UpdateValidator;
use App\Http\Responses\RespondServerErrorJson;
use App\Http\Responses\RespondSuccessJson;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

final class UpdateOperation extends AbstractOperation
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
            $input = $this->requestData(
                [
                    'firstname',
                    'lastname',
                    'email',
                ]
            );
            $this->validateWithResponse(UpdateValidator::class, $input);
            $response = new RespondSuccessJson('success', $this->userRepository->update($user, $input));
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd dodawania użytkownika');
        }
        return $this->runResponse($response);
    }
}
