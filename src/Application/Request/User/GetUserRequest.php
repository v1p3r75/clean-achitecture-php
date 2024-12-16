<?php

namespace Application\Request\User;

class GetUserRequest
{

    public function __construct(
        public string $id
    ) {}
}