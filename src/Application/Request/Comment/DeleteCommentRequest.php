<?php

namespace Application\Request\Comment;

class DeleteCommentRequest
{
    public function __construct(
        public string $id
    ) {}
}