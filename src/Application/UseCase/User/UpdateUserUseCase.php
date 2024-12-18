<?php

namespace Application\UseCase\User;

use Application\Contract\PasswordHasherInterface;
use Application\Contract\ValidatorInterface;
use Application\Presenter\ShowUserPresenterInterface;
use Application\Request\User\UpdateUserRequest;
use Application\Response\UserResponse;
use Application\Service\HttpCode;
use Domain\Repository\UserRepositoryInterface;

readonly class UpdateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator
    ) {}

    public function execute(
        UpdateUserRequest          $request,
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

        $user = $this->userRepository->find($request->id);

        if(!$user) {
            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $presenter->present($response);
            return;
        }

        if ($request->email) {
            $user->setEmail($request->email);
        }
        if ($request->password) {
            $user->setPassword($this->passwordHasher->hash($request->password));
        }
        if ($request->username) {
            $user->setUsername($request->username);
        }
        $this->userRepository->save($user);

        $response->setHttpCode(HttpCode::HTTP_OK);
        $response->setUser($user);

        $presenter->present($response);
    }

}
