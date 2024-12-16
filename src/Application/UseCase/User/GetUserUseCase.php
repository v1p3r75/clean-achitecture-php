<?php

namespace Application\UseCase\User;

use Application\Presenter\ShowUserPresenter;
use Application\Request\User\GetUserRequest;
use Application\Response\UserResponse;
use Application\Service\HttpCode;
use Domain\Repository\UserRepositoryInterface;

readonly class GetUserUseCase
{

    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function execute(
        GetUserRequest $request,
        ShowUserPresenter $presenter
    ): void {

        $user = $this->userRepository->find($request->id);

        $response = new UserResponse();

        if (!$user) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $presenter->present($response);
            return;
        }

        $response->setHttpCode(HttpCode::HTTP_OK);
        $response->setUser($user);

        $presenter->present($response);

    }
}