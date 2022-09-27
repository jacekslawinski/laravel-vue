<?php

namespace Tests;

use App\Data\Models\User;
use App\Data\Models\User\Token;
use App\Repositories\Interfaces\User\AuthRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\App;
use Illuminate\Testing\TestResponse;

class ApiTestCase extends AbstractTestCase
{
    use DatabaseTransactions;

    /**
     *
     * @param string $routeName
     * @param array $routeParams
     * @param array $data
     * @param array $headers
     * @return TestResponse
     */
    protected function postRequest(
        string $routeName,
        array $routeParams = [],
        array $data = [],
        array $headers = []
    ): TestResponse {
        return $this->post($this->routeApi($routeName, $routeParams), $data, $headers);
    }

    /**
     *
     * @param string $routeName
     * @param array $routeParams
     * @param array $headers
     * @return TestResponse
     */
    protected function getRequest(string $routeName, array $routeParams = [], array $headers = []): TestResponse
    {
        return $this->get($this->routeApi($routeName, $routeParams), $headers);
    }

    /**
     *
     * @param string $routeName
     * @param array $routeParams
     * @param array $data
     * @param array $headers
     * @return TestResponse
     */
    protected function patchRequest(
        string $routeName,
        array $routeParams = [],
        array $data = [],
        array $headers = []
    ): TestResponse {
        return $this->patch($this->routeApi($routeName, $routeParams), $data, $headers);
    }

    /**
     *
     * @param string $routeName
     * @param array $routeParams
     * @param array $data
     * @param array $headers
     * @return TestResponse
     */
    protected function putRequest(
        string $routeName,
        array $routeParams = [],
        array $data = [],
        array $headers = []
    ): TestResponse {
        return $this->put($this->routeApi($routeName, $routeParams), $data, $headers);
    }

    /**
     *
     * @param string $routeName
     * @param array $routeParams
     * @param array $headers
     * @return TestResponse
     */
    protected function deleteRequest(string $routeName, array $routeParams = [], array $headers = []): TestResponse
    {
        return $this->delete($this->routeApi($routeName, $routeParams), [], $headers);
    }

    /**
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    private function routeApi(string $name, array $parameters): string
    {
        return app('url')->route($name, $parameters);
    }
}
