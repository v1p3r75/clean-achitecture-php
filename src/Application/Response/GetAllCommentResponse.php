<?php

namespace Application\Response;

use Domain\Entity\Comment;

class GetAllCommentResponse extends BaseResponse
{

    /**
     * @var Comment[]
     */
    private array $comments = [];

    /**
     * @return Comment[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     */
    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }

}