<?php

namespace Domain\Entity;

use DateTimeImmutable;
use Domain\ValueObject\Id;

class Post
{

    private Id $id;

    private string $title;

    private string $content;

    /**
     * @var Comment[]
     */
    private array $comments = [];


    private ?DateTimeImmutable $publishedAt = null;

    private User $user;

    public function __construct() {
        $this->id = new Id();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id->getValue();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getPublishedAt(): ?DateTimeImmutable
    {
        return $this->publishedAt;
    }

    /**
     * @param DateTimeImmutable|null $publishedAt
     */
    public function setPublishedAt(?DateTimeImmutable $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }

}