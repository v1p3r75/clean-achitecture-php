<?php

namespace Application\Request\Comment;

class CreateCommentRequest
{
    public function __construct(
        public string $content,
        public string $userId,
        public string $postId
    ) {}

}