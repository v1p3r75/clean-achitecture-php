<?php

namespace Domain\Repository;

use Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user);

    public function find(string $id): ?User;

    public function findAll(): array;
}
