<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractRespondJson extends Response implements ResponseInterface
{
    /**
     *
     * @var mixed $result
     */
    protected $result;

    /**
     *
     * @var string $message
     */
    protected string $message;

    /**
     *
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        return response()->json($this->prepareResponse(), $this->getResponseHeader());
    }

    /**
     *
     * @return int
     */
    abstract public function getResponseHeader(): int;

    /**
     *
     * @return array
     */
    protected function prepareResponse(): array
    {
        return [
            'result'  => $this->result,
            'message' => $this->message
        ];
    }
}
