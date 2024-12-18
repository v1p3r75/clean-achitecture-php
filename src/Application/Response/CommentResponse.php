<?php

namespace Application\Response;

use Domain\Entity\Comment;

class CommentResponse extends BaseResponse
{

    private ?Comment $comment = null;

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): void
    {
        $this->comment = $comment;
    }


}