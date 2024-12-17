<?php

namespace Application\Response;

use Domain\Entity\Post;

class GetAllPostResponse extends BaseResponse
{

    /**
     * @var Post[]
     */
    private array $posts = [];

    /**
     * @return Post[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    /**
     * @param Post[] $posts
     */
    public function setPosts(array $posts): void
    {
        $this->posts = $posts;
    }
}