<?php

namespace Tests\Feature\Hardware;

use App\Models\Hardware;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\ApiTestCase;

/**
 *
 * @group api
 * @group HardwareController
 */
class DeleteTest extends ApiTestCase
{
    use WithFaker;

    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'hardware.destroy';

    /**
     *
     * @test
     */
    public function deleteSuccess(): void
    {
        $hardware = factory(Hardware::class)->create();
        $response = $this->deleteRequest($this->apiRoute, ['hardware' => $hardware->id]);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @test
     */
    public function deleteFailureNoHardware(): void
    {
        $hardware = factory(Hardware::class)->create();
        $response = $this->deleteRequest($this->apiRoute, ['hardware' => $hardware->id + 1]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
