<?php

namespace Application\UseCase\User;

use Application\Presenter\GetAllUserPresenterInterface;
use Application\Request\User\GetAllUserRequest;
use Application\Response\GetAllUserResponse;
use Application\Service\HttpCode;
use Domain\Repository\UserRepositoryInterface;

readonly class GetAllUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function execute(
        GetAllUserRequest $request,
        GetAllUserPresenterInterface $presenter
    ): void {

        $users = $this->userRepository->findAll();

        $response = new GetAllUserResponse();

        $response->setHttpCode(HttpCode::HTTP_OK);
        $response->setUsers($users);

        $presenter->present($response);

    }
}