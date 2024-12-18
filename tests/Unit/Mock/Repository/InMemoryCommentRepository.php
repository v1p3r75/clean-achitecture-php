<?php

namespace Tests\Unit\Mock\Repository;

use Domain\Entity\Comment;
use Domain\Repository\CommentRepositoryInterface;

class InMemoryCommentRepository implements CommentRepositoryInterface
{

    private array $data = [];

    public function save(Comment $comment): void
    {
        $this->data[$comment->getId()] = $comment;
    }

    public function find(string $id): ?Comment
    {
        return $this->data[$id] ?? null;
    }

    public function findAll(): array
    {
       return $this->data;
    }

    public function delete(string $id): void
    {

        if (isset($this->data[$id])) {
            $this->data = array_filter(
                $this->data,
                fn(Comment $comment) => $comment->getId() !== $id
            );
        }
    }

    public function findByUser(string $userId): array
    {
        return array_filter(
            $this->data,
            fn(Comment $comment) => $comment->getUser()->getId() === $userId
        );
    }

    public function findByPost(string $postId): array
    {
        return array_filter(
            $this->data,
            fn(Comment $comment) => $comment->getPost()->getId() === $postId
        );
    }
}