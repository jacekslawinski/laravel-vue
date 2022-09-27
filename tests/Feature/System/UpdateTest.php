<?php

namespace Tests\Feature\System;

use App\Models\System;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\ApiTestCase;

/**
 *
 * @group api
 * @group SystemController
 */
class UpdateTest extends ApiTestCase
{
    use WithFaker;

    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'system.update';

    /**
     *
     * @test
     */
    public function updateSuccess(): void
    {
        $system = factory(System::class)->create();
        $response = $this->putRequest($this->apiRoute, [
            'system' => $system->id
        ], [
            'name' => $this->faker->text(100),
        ]);
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
    public function updateFailureNoName(): void
    {
        $system = factory(System::class)->create();
        $response = $this->putRequest($this->apiRoute, [
            'system' => $system->id
        ], [
            'name' => '',
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     *
     * @test
     */
    public function updateFailureNameTooLong(): void
    {
        $system = factory(System::class)->create();
        $response = $this->putRequest($this->apiRoute, [
            'system' => $system->id
        ], [
            'name' => $this->faker->lexify(\str_repeat('?', 101)),
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
