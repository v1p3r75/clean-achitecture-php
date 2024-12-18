<?php

namespace Domain\Repository;

use Domain\Entity\Post;

interface PostRepositoryInterface
{
    public function save(Post $post): void;

    public function find(string $id): ?Post;

    /**
     * @return Post[]
     */
    public function findAll(): array;

    /**
     * @param string $userId
     * @return Post[]
     */
    public function getByUser(string $userId): array;

    public function delete(string $id): void;

}
