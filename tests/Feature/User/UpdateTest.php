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
class UpdateTest extends ApiTestCase
{
    use WithFaker;

    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'user.update';

    /**
     *
     * @return array
     */
    public function updateData(): array
    {
        $this->refreshApplication();
        $this->setUpFaker();
        return [
            [
                [
                    'lastname' => $this->faker->lastName,
                    'email' => $this->faker->email,
                ]
            ],
            [
                [
                    'firstname' => $this->faker->lexify(\str_repeat('?', 51)),
                    'lastname' => $this->faker->lastName,
                    'email' => $this->faker->email,
                ]
            ],
            [
                [
                    'firstname' => $this->faker->firstName,
                    'email' => $this->faker->email,
                ]
            ],
            [
                [
                    'firstname' => $this->faker->firstName,
                    'lastname' => $this->faker->lexify(\str_repeat('?', 51)),
                    'email' => $this->faker->email,
                ]
            ],
            [
                [
                    'firstname' => $this->faker->firstName,
                    'lastname' => $this->faker->lastName,
                ]
            ],
            [
                [
                    'firstname' => $this->faker->firstName,
                    'lastname' => $this->faker->lastName,
                    'email' => $this->faker->lexify(\str_repeat('?', 256)),
                ]
            ],
            [
                [
                    'firstname' => $this->faker->firstName,
                    'lastname' => $this->faker->lastName,
                    'email' => $this->faker->word,
                ]
            ]
        ];
    }

    /**
     *
     * @test
     */
    public function updateSuccess(): void
    {
        $user = factory(User::class)->create();
        $response = $this->putRequest($this->apiRoute, [
            'user' => $user->id
        ], [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
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
    public function updateFailureBadUser(): void
    {
        $user = factory(User::class)->create();
        $response = $this->putRequest($this->apiRoute, [
            'user' => $user->id + 1
        ], [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
        ]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @test
     * @dataProvider updateData
     */
    public function updateFailureBadData(array $data): void
    {
        $user = factory(User::class)->create();
        $response = $this->putRequest($this->apiRoute, ['user' => $user->id], $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     *
     * @test
     */
    public function updateFailureEmailNoUnique(): void
    {
        $userOne = factory(User::class)->create();
        $userTwo = factory(User::class)->create();
        $response = $this->putRequest($this->apiRoute, [
            'user' => $userOne->id
        ], [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $userTwo->email,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
