<?php

namespace Tests\Unit\Domain\User\Adapters;

use Domain\User\Contract\UserRepositoryInterface;
use Domain\User\Entity\User;

class InMemoryUserRepository implements UserRepositoryInterface
{
    /** @var User[] */
    private array $users = [];

    public function save(User $user) {

        $this->users[$user->getId()] = $user;
    }

    public function find(string $id): User|null {

        return $this->users[$id] ?? null;
    }

    public function findAll(): array
    {
        return $this->users;
    }
}
