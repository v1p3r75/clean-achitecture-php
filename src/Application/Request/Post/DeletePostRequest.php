<?php

namespace Application\Request\Post;

class DeletePostRequest
{
    public function __construct(
        public string $id
    ) {}
}