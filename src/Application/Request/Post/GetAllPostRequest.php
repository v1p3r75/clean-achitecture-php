<?php

namespace Application\Request\Post;

class GetAllPostRequest
{
    public function __construct(
        public ?string $userId = null
    ){
    }
}