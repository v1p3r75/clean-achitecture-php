<?php

namespace Domain\Repository;

use Domain\Entity\Comment;

interface CommentRepositoryInterface
{
    public function save(Comment $comment): void;

    public function find(string $id): ?Comment;

    /**
     * @return Comment[]
     */
    public function findAll(): array;

    /**
     * @return Comment[]
     */
    public function findByUser(string $userId): array;

    /**
     * @return Comment[]
     */
    public function findByPost(string $postId): array;

    public function delete(string $id): void;

}
