<?php

namespace Application\UseCase\User;

use Application\Contract\PasswordHasherInterface;
use Application\Contract\ValidatorInterface;
use Application\Presenter\ShowUserPresenterInterface;
use Application\Request\User\CreateUserRequest;
use Application\Response\UserResponse;
use Application\Service\HttpCode;
use DateTimeImmutable;
use Domain\Entity\User;
use Domain\Repository\UserRepositoryInterface;

readonly class CreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface,
        private PasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator
    ) {}

    public function execute(
        CreateUserRequest          $request,
        ShowUserPresenterInterface $presenter,
    ): void
    {

        $response = new UserResponse();

        if (!$this->validator->validate($request)) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_BAD_REQUEST);
            $response->setErrors($this->validator->getErrors());
            $presenter->present($response);
            return;
        }

        $user = new User();
        $user->setUsername($request->username);
        $user->setEmail($request->email);
        $user->setPassword($this->passwordHasher->hash($request->password));
        $user->setCreatedAt(new DateTimeImmutable());

        $this->userRepositoryInterface->save($user);

        $response->setHttpCode(HttpCode::HTTP_CREATED);
        $response->setUser($user);

        $presenter->present($response);
    }

}
