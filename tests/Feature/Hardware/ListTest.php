<?php

namespace Tests\Feature\Hardware;

use App\Models\Hardware;
use Tests\ApiTestCase;

/**
 * @group api
 * @group HardwareController
 */
class ListTest extends ApiTestCase
{
    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'hardware.index';

    /**
     * @test
     */
    public function listSuccess(): void
    {
        factory(Hardware::class, 2)->create();
        $response = $this->getRequest($this->apiRoute, []);
        $response->assertOk();

        $response->assertJsonStructure([
            'message',
            'result' => [
                '*' => [
                    'id',
                    'name',
                    'serialNumber',
                    'productionMonth',
                    'systemId'
                ]
            ]
        ]);
    }
}
