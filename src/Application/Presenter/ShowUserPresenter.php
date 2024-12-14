<?php

namespace Application\Presenter;

use Application\Response\UserResponse;

interface ShowUserPresenter
{
    public function present(UserResponse $response): void;

}