<?php

namespace Application\Presenter;

use Application\Response\GetAllUserResponse;

interface GetAllUserPresenter
{
    public function present(GetAllUserResponse $response): void;

}