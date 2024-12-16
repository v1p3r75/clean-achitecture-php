<?php

namespace Application\Presenter;

use Application\Response\GetAllUserResponse;

interface GetAllUserPresenterInterface
{
    public function present(GetAllUserResponse $response): void;

}