<?php

namespace Tests\Feature\System;

use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\ApiTestCase;

/**
 *
 * @group api
 * @group SystemController
 */
class StoreTest extends ApiTestCase
{
    use WithFaker;

    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'system.store';

    /**
     *
     * @test
     */
    public function storeSuccess(): void
    {
        $response = $this->postRequest(
            $this->apiRoute,
            [],
            [
                'name' => $this->faker->text(100)
            ]
        );
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'result'
        ]);
    }

    /**
     *
     * @test
     */
    public function storeFailureNoName(): void
    {
        $response = $this->postRequest($this->apiRoute, [], ['name' => '']);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     *
     * @test
     */
    public function storeFailureNameTooLong(): void
    {
        $response = $this->postRequest(
            $this->apiRoute,
            [],
            [
                'name' => $this->faker->lexify(\str_repeat('?', 101))
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
