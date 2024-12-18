<?php

namespace Application\Request\Post;

class UpdatePostRequest
{
    public function __construct(
        public string $id,
        public ?string $title = null,
        public ?string $content = null,
    ) {}

}