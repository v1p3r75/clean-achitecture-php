<?php

namespace Application\Request\User;

class CreateUserRequest
{
    public function __construct(
        public string $username,
        public string $password,
        public string $email
    ){}

}
