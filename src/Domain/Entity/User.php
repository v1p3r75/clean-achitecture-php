<?php

namespace Domain\Entity;

use DateTimeImmutable;
use Domain\ValueObject\Id;

class User
{
    private Id $id;

    private string $username;

    private string $password;

    private string $email;

    private bool $isAdmin = false;

    private ?DateTimeImmutable $createdAt = null;

    public function __construct() {

        $this->id = new Id();
    }


    public function getId(): string
    {
        return $this->id->getValue();
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}
