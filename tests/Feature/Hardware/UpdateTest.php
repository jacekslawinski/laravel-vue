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
class UpdateTest extends ApiTestCase
{
    use WithFaker;

    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'hardware.update';

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
                    'serial_number' => $this->faker->uuid,
                    'production_month' => $this->faker->date('Y-m'),
                ]
            ],
            [
                [
                    'name' => $this->faker->lexify(\str_repeat('?', 101)),
                    'serial_number' => $this->faker->uuid,
                    'production_month' => $this->faker->date('Y-m'),
                ]
            ],
            [
                [
                    'name' => $this->faker->company,
                    'production_month' => $this->faker->date('Y-m'),
                ]
            ],
            [
                [
                    'name' => $this->faker->company,
                    'serial_number' => $this->faker->lexify(\str_repeat('?', 101)),
                    'production_month' => $this->faker->date('Y-m'),
                ]
            ],
            [
                [
                    'name' => $this->faker->company,
                    'serial_number' => $this->faker->uuid,

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
        $hardware = factory(Hardware::class)->create();
        $response = $this->putRequest($this->apiRoute, [
            'hardware' => $hardware->id
        ], [
            'name' => $this->faker->company,
            'serial_number' => $this->faker->uuid,
            'production_month' => $this->faker->date('Y-m'),
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
    public function updateFailureBadHardware(): void
    {
        $hardware = factory(Hardware::class)->create();
        $response = $this->putRequest($this->apiRoute, [
            'hardware' => $hardware->id + 1
        ], [
            'name' => $this->faker->company,
            'serial_number' => $this->faker->uuid,
            'production_month' => $this->faker->date('Y-m'),
            'system_id' => 1
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
        $hardware = factory(Hardware::class)->create();
        $response = $this->putRequest($this->apiRoute, ['hardware' => $hardware->id], $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
