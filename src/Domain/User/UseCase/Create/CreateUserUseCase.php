<?php

namespace Domain\User\UseCase\Create;

use Domain\User\Contract\UserRepositoryInterface;
use Domain\User\Entity\User;

class CreateUserUseCase
{

    public function __construct(
        private CreateUserRequest $request,
        private CreateUserPresenterInterface $presenter,
        private UserRepositoryInterface $userRepositoryInterface
    ){}

    public function execute() 
    {
        $user = new User();
        $user->setUsername($this->request->username);
        $user->setEmail($this->request->email);
        $user->setPassword($this->request->password);

        $this->userRepositoryInterface->save($user);

        $response = new CreateUserResponse($user);
        
        return $this->presenter->present($response);
    }

}