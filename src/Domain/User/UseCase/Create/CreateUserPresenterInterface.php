<?php

namespace Domain\User\UseCase\Create;

use Domain\User\UseCase\Create;

interface CreateUserPresenterInterface
{
    public function present(CreateUserResponse $createUserResponse); 
}
