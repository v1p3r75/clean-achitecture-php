<?php

namespace Domain\Repository;

use Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function find(string $id): ?User;

    public function findOneByEmail(string $email): ?User;

    public function findAll(): array;

    public function delete(string $id): void;
}
