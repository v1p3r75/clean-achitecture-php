<?php

namespace Domain\User\UseCase\Create;

use Domain\User\Entity\User;

class CreateUserResponse
{
    public bool $status = true;

    public int $code;

    public ?User $user;

    public string $message;

    public array $errors = [];


}
