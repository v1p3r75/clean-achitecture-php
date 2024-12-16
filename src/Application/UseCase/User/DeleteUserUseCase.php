<?php

namespace Application\UseCase\User;

use Application\Presenter\DeleteUserPresenterInterface;
use Application\Presenter\ShowUserPresenterInterface;
use Application\Request\User\DeleteUserRequest;
use Application\Request\User\GetUserRequest;
use Application\Response\BaseResponse;
use Application\Response\UserResponse;
use Application\Service\HttpCode;
use Domain\Repository\UserRepositoryInterface;

readonly class DeleteUserUseCase
{

    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function execute(
        DeleteUserRequest $request,
        DeleteUserPresenterInterface $presenter
    ): void {

        $user = $this->userRepository->find($request->id);

        $response = new BaseResponse();

        if (!$user) {

            $response->setStatus(false);
            $response->setMessage('user not found');
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $presenter->present($response);
            return;
        }

        $this->userRepository->delete($request->id);

        $response->setHttpCode(HttpCode::HTTP_NO_CONTENT);
        $response->setMessage('user deleted');
        $presenter->present($response);

    }
}