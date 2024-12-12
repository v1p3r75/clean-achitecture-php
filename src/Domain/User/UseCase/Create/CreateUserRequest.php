<?php

namespace Domain\User\UseCase\Create;

use DateTimeImmutable;

class CreateUserRequest
{
    public function __construct(
        public string $username,
        public string $password,
        public string $email
    ){}
}
