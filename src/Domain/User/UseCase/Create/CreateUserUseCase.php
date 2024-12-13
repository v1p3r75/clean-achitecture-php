<?php

namespace Domain\User\UseCase\Create;

use Domain\User\Contract\UserRepositoryInterface;
use Domain\User\Entity\User;

class CreateUserUseCase
{

    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface
    ) {}

    public function execute(
        CreateUserRequest $request,
        CreateUserPresenterInterface $presenter,
    ) {

        $user = new User();
        $user->setUsername($request->username);
        $user->setEmail($request->email);
        $user->setPassword($request->password);

        $this->userRepositoryInterface->save($user);

        $response = new CreateUserResponse();
        $response->setHttpCode(201);
        $response->setUser($user);

        return $presenter->present($response);
    }

    private function validate(CreateUserRequest $request): true | array
    {
        //TODO: validate

        return true;
    }
}
