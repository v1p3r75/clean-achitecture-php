<?php

namespace Application\Request\User;

class UpdateUserRequest
{
    public function __construct(
        public string $id,
        public ?string $username = null,
        public ?string $password = null,
        public ?string $email = null
    ){}

}
