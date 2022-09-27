<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\ApiTestCase;

/**
 *
 * @group api
 * @group UserController
 */
class DeleteTest extends ApiTestCase
{
    use WithFaker;

    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'user.destroy';

    /**
     *
     * @test
     */
    public function deleteSuccess(): void
    {
        $user = factory(User::class)->create();
        $response = $this->deleteRequest($this->apiRoute, [
            'user' => $user->id
        ]);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @test
     */
    public function deleteFailureNoUser(): void
    {
        $user = factory(User::class)->create();
        $response = $this->deleteRequest($this->apiRoute, [
            'user' => $user->id + 1
        ]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
