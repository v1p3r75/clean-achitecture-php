<?php

namespace Application\Presenter;

use Application\Response\GetAllCommentResponse;

interface GetAllCommentPresenterInterface
{
    public function present(GetAllCommentResponse $response): void;

}