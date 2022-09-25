<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\System;
use App\Repositories\Interfaces\SystemRepositoryInterface;
use Illuminate\Support\Collection;

final class SystemRepository implements SystemRepositoryInterface
{
    /**
     *
     * @return Collection
     */
    public function list(): Collection
    {
        return System::all();
    }

    /**
     *
     * @param array $attributes
     * @return System
     */
    public function store(array $attributes): System
    {
        return System::create($attributes);
    }

    /**
     *
     * @param System $system
     * @param array $attributes
     * @return void
     */
    public function update(System $system, array $attributes): void
    {
        $system->update($attributes);
    }

    /**
     *
     * @param System $system
     * @return void
     */
    public function delete(System $system): void
    {
        $system->delete();
    }

    /**
     *
     * @param int $id
     * @return System
     */
    public function getById(int $id): System
    {
        return System::findOrFail($id);
    }
}
