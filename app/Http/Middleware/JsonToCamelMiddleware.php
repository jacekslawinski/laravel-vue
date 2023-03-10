<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class JsonToCamelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $content = json_decode($response->getContent(), true);
        if (null !== $content) {
            $response->setContent(json_encode($this->convertToCamelCase($content)));
        }

        return $response;
    }

    /**
     *
     * @param mixed $data
     * @return array
     */
    private function convertToCamelCase($data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = $this->convertToCamelCase($value);
            }
            $result[Str::camel($key)] = $value;
        }

        return $result;
    }
}
