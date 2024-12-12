<?php

namespace Domain\User\Contract;

use Domain\User\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user);

    public function find(string $id): ?User;

    public function findAll(): array;
}
