<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Hardware;
use App\Repositories\Interfaces\HardwareRepositoryInterface;
use Illuminate\Support\Collection;

final class HardwareRepository implements HardwareRepositoryInterface
{
    /**
     *
     * @return Collection
     */
    public function list(): Collection
    {
        return Hardware::with(['userHardware.user'])
            ->get();
    }

    /**
     *
     * @param array $attributes
     * @return Hardware
     */
    public function store(array $attributes): Hardware
    {
        $hardware = Hardware::create($attributes);
        if (!empty($attributes['system_id'])) {
            $hardware->system()
                ->create(
                    [
                        'system_id' => $attributes['system_id']
                    ]
                );
            $hardware->load('system');
        }
        return $hardware;
    }

    /**
     *
     * @param Hardware $hardware
     * @param array $attributes
     * @return void
     */
    public function update(Hardware $hardware, array $attributes): void
    {
        if (empty($attributes['system_id'])) {
            $hardware->system()->delete();
        }
        $hardware->update($attributes);
    }

    /**
     *
     * @param Hardware $hardware
     * @return void
     */
    public function delete(Hardware $hardware): void
    {
        $hardware->delete();
    }

    /**
     *
     * @param int $id
     * @return Hardware
     */
    public function getById(int $id): Hardware
    {
        return Hardware::findOrFail($id);
    }
}
