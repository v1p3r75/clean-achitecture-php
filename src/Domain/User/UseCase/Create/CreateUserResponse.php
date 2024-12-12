<?php

namespace Domain\User\UseCase\Create;

use Domain\User\Entity\User;

class CreateUserResponse
{

    private int $httpCode = 200;

    private ?User $user;

    private array $errors = [];


    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function getHttpCode(): int  
    {
        return $this->httpCode;
    }

    public function setHttpCode(int $code): self
    {
        $this->httpCode = $code;
        return $this;
    }
}
