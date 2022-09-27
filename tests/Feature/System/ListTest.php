<?php

namespace Tests\Feature\System;

use App\Models\System;
use Tests\ApiTestCase;

/**
 *
 * @group api
 * @group SystemController
 */
class ListTest extends ApiTestCase
{
    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'system.index';

    /**
     *
     * @test
     */
    public function listSuccess(): void
    {
        factory(System::class)->create();
        factory(System::class)->create();
        $response = $this->getRequest($this->apiRoute, []);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'result' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]
        ]);
    }
}
