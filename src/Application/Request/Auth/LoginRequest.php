<?php

namespace Application\Request\Auth;

class LoginRequest
{
    public function __construct(
        public string $email,
        public string $password
    ){
    }
}