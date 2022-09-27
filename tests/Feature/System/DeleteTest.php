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
class DeleteTest extends ApiTestCase
{
    use WithFaker;

    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'system.destroy';

    /**
     *
     * @test
     */
    public function deleteSuccess(): void
    {
        $system = factory(System::class)->create();
        $response = $this->deleteRequest($this->apiRoute, [
            'system' => $system->id
        ]);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @test
     */
    public function deleteFailureNoSystem(): void
    {
        $system = factory(System::class)->create();
        $response = $this->deleteRequest($this->apiRoute, [
            'system' => $system->id + 1
        ]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
