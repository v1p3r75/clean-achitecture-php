<?php

namespace Application\Request\Comment;

class GetAllCommentRequest
{
    public function __construct(
        public ?string $userId = null,
        public ?string $postId = null
    ){
    }
}