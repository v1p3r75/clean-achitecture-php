<?php

namespace Application\Presenter;

use Application\Response\BaseResponse;

interface DeleteCommentPresenterInterface
{
    public function present(BaseResponse $response): void;
}