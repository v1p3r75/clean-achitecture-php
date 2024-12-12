<?php

namespace Tests\Unit\Domain\User\Adapters;

use Domain\User\UseCase\Create\CreateUserResponse;
use Domain\User\UseCase\Create\CreateUserPresenterInterface;

class CreateUserPresenterJson implements CreateUserPresenterInterface
{

    public function present(CreateUserResponse $createUserResponse)
    {
        $user = $createUserResponse->getUser();
        $data = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail()
        ];

        return json_encode($data);
    }
}