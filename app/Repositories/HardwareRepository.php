<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Hardware;
use App\Repositories\Interfaces\HardwareRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

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
        return $hardware = Hardware::create($attributes);
    }

    /**
     *
     * @param Hardware $hardware
     * @param array $attributes
     * @return void
     */
    public function update(Hardware $hardware, array $attributes): void
    {
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
