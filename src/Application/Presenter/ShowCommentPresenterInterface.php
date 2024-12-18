<?php

namespace Application\Presenter;

use Application\Response\CommentResponse;

interface ShowCommentPresenterInterface
{
    public function present(CommentResponse $response): void;

}