<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class UserRepository implements UserRepositoryInterface
{
    /**
     *
     * @return Collection
     */
    public function list(): Collection
    {
        return User::with('userHardwares.hardware')
            ->get();
    }

    /**
     *
     * @param array $attributes
     * @return User
     */
    public function store(array $attributes): User
    {
        return User::create($attributes);
    }

    /**
     *
     * @param User $user
     * @param array $attributes
     * @return void
     */
    public function update(User $user, array $attributes): void
    {
        $user->update($attributes);
    }

    /**
     *
     * @param User $user
     * @return void
     */
    public function delete(User $user): void
    {
        $user->delete();
    }

    /**
     *
     * @param int $id
     * @return User
     */
    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }
}
