<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Responses\RespondValidationErrorsJson;
use App\Http\Responses\ResponseJsonTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseJsonTrait;

    /**
     *
     * @param mixed $request
     * @param Throwable $exception
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->runResponse(new RespondValidationErrorsJson('Błędy walidacji', $exception->getErrors()));
        }
        return response()->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
    }
}
