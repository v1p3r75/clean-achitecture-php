<?php

namespace Application\Request\Comment;

class UpdateCommentRequest
{
    public function __construct(
        public string $id,
        public ?string $content = null,
    ) {}

}