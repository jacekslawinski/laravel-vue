<?php

namespace Tests\Feature\Hardware;

use App\Models\Hardware;
use App\Repositories\Interfaces\HardwareRepositoryInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\ApiTestCase;
use Mockery;

/**
 *
 * @group api
 * @group HardwareController
 */
class StoreTest extends ApiTestCase
{
    use WithFaker;

    /**
     *
     * @var string $apiRoute
     */
    private $apiRoute = 'hardware.store';

    /**
     *
     * @return array
     */
    public function storeData(): array
    {
        $this->refreshApplication();
        $this->setUpFaker();
        return [
            [
                [
                    'serial_number' => $this->faker->uuid,
                    'production_month' => $this->faker->date('Y-m'),
                    'system_id' => 1
                ]
            ],
            [
                [
                    'name' => $this->faker->lexify(\str_repeat('?', 101)),
                    'serial_number' => $this->faker->uuid,
                    'production_month' => $this->faker->date('Y-m'),
                    'system_id' => 1
                ]
            ],
            [
                [
                    'name' => $this->faker->company,
                    'production_month' => $this->faker->date('Y-m'),
                    'system_id' => 1
                ]
            ],
            [
                [
                    'name' => $this->faker->company,
                    'serial_number' => $this->faker->lexify(\str_repeat('?', 101)),
                    'production_month' => $this->faker->date('Y-m'),
                    'system_id' => 1
                ]
            ],
            [
                [
                    'name' => $this->faker->company,
                    'production_month' => $this->faker->uuid,
                    'system_id' => 1
                ]
            ]
        ];
    }

    /**
     *
     * @test
     */
    public function storeSuccess(): void
    {
        $repository = Mockery::mock(HardwareRepositoryInterface::class);
        $repository->shouldReceive('store')
            ->with([
                'name' => '123',
                'serial_number' => '234',
                'production_month' => '1995-11',
                'system_id' => 1
            ])
            ->once()
            ->andReturn(new Hardware([
                'name' => '123',
                'serial_number' => '234',
                'production_month' => '1995-11',
                'system_id' => 1
            ]));
        $this->app->instance(HardwareRepositoryInterface::class, $repository);
        $response = $this->postRequest($this->apiRoute, [], [
            'name' => '123',
            'serial_number' => '234',
            'production_month' => '1995-11',
            'system_id' => 1
        ]);
        $response->assertOK();
        $response->assertJsonStructure([
            'message',
            'result' => [
                'id',
                'name',
                'serialNumber',
                'productionMonth',
                'systemId'
            ]
        ]);
    }

    /**
     *
     * @test
     * @dataProvider storeData
     */
    public function storeFailureBadData(array $data): void
    {
        $response = $this->postRequest($this->apiRoute, [], $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
