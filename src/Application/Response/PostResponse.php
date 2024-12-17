<?php

namespace Application\Response;

use Domain\Entity\Post;

class PostResponse extends BaseResponse
{

    private ?Post $post = null;

    /**
     * @return Post|null
     */
    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     * @param Post|null $post
     */
    public function setPost(?Post $post): void
    {
        $this->post = $post;
    }

}