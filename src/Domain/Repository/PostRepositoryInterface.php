<?php

namespace Domain\Repository;

use Domain\Entity\Post;

interface PostRepositoryInterface
{
    public function save(Post $post): void;

    public function find(string $id): ?Post;

    public function findAll(): array;

    public function delete(string $id): void;
}
