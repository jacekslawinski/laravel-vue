<?php

namespace Tests\Feature\User;

use Tests\ApiTestCase;

/**
 *
 * @group api
 * @group UserController
 */
class ListTest extends ApiTestCase
{
    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'user.index';

    /**
     *
     * @test
     */
    public function listSuccess(): void
    {
        $response = $this->getRequest($this->apiRoute, []);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'result' => [
                '*' => [
                    'id',
                    'firstname',
                    'lastname',
                    'email',
                    'userHardwares'
                ]
            ]
        ]);
    }
}
