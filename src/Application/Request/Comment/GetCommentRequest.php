<?php

namespace Application\Request\Comment;

class GetCommentRequest
{
    public function __construct(
        public string $id
    ) {}
}