<?php

namespace Application\Request\Post;

class GetPostRequest
{
    public function __construct(
        public string $id
    ) {}
}