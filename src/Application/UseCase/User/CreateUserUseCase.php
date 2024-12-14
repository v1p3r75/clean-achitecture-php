<?php

namespace Application\UseCase\User;

use Application\Contract\PasswordHasherInterface;
use Application\Presenter\ShowUserPresenter;
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
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function execute(
        CreateUserRequest $request,
        ShowUserPresenter $presenter,
    ): void
    {

        $user = new User();
        $user->setUsername($request->username);
        $user->setEmail($request->email);
        $user->setPassword($this->passwordHasher->hash($request->password));
        $user->setCreatedAt(new DateTimeImmutable());

        $this->userRepositoryInterface->save($user);

        $response = new UserResponse();
        $response->setHttpCode(HttpCode::HTTP_CREATED);
        $response->setUser($user);

        $presenter->present($response);
    }

}
