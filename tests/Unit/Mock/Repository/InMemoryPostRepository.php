<?php

namespace Tests\Unit\Mock\Repository;

use Domain\Entity\Post;
use Domain\Repository\PostRepositoryInterface;

class InMemoryPostRepository implements PostRepositoryInterface
{

    private array $data = [];

    public function save(Post $post): void
    {
        $this->data[$post->getId()] = $post;
    }

    public function find(string $id): ?Post
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
                fn(Post $post) => $post->getId() !== $id
            );
        }
    }


    public function getByUser(string $userId): array
    {
        return array_filter(
            $this->data,
            fn(Post $post) => $post->getUser()->getId() === $userId
        );
    }
}