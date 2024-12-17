<?php

namespace Application\Presenter;

use Application\Response\BaseResponse;

interface DeletePostPresenterInterface
{
    public function present(BaseResponse $response): void;
}