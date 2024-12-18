<?php

namespace Domain\Entity;

use DateTimeImmutable;
use Domain\ValueObject\Id;

class Comment
{

    private Id $id;

    private string $content;

    private User $user;

    private Post $post;

    private ?DateTimeImmutable $createdAt = null;

    public function __construct() {
        $this->id = new Id();
    }

    public function getId(): string
    {
        return $this->id->getValue();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}