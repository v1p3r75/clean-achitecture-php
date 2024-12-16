<?php

namespace Application\Presenter;

use Application\Response\BaseResponse;

interface DeleteUserPresenterInterface
{
    public function present(BaseResponse $response): void;
}