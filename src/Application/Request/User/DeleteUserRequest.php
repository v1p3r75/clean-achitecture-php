<?php

namespace Application\Request\User;

class DeleteUserRequest
{
    public function __construct(
        public string $id
    ) {}
}