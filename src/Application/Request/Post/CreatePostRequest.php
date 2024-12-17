<?php

namespace Application\Request\Post;

class CreatePostRequest
{
    public function __construct(
        public string $title,
        public string $content,
        public string $userId
    ) {}

}