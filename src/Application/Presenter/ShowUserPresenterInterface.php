<?php

namespace Application\Presenter;

use Application\Response\UserResponse;

interface ShowUserPresenterInterface
{
    public function present(UserResponse $response): void;

}