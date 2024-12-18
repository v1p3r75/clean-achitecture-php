<?php

namespace Tests\Unit\Mock\Repository;

use Domain\Entity\User;
use Domain\Repository\UserRepositoryInterface;

class InMemoryUserRepository implements UserRepositoryInterface
{

    private array $users = [];

    public function save(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    public function find(string $id): ?User
    {
        return $this->users[$id] ?? null;
    }

    public function findAll(): array
    {
       return $this->users;
    }

    public function findOneByEmail(string $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }

    public function delete(string $id): void
    {

        if (isset($this->users[$id])) {
            $this->users = array_filter(
                $this->users,
                fn(User $user) => $user->getId() !== $id
            );
        }
    }
}