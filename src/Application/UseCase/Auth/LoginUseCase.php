<?php

namespace Application\UseCase\Auth;

use Application\Contract\PasswordHasherInterface;
use Application\Contract\ValidatorInterface;
use Application\Presenter\ShowUserPresenterInterface;
use Application\Request\Auth\LoginRequest;
use Application\Response\UserResponse;
use Application\Service\HttpCode;
use Domain\Repository\UserRepositoryInterface;

readonly class LoginUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator
    ){
    }

    public function execute(LoginRequest $request, ShowUserPresenterInterface $presenter): void
    {
        $response = new UserResponse();

        if (!$this->validator->validate($request)) {
            $response->setStatus(false);
            $response->setStatus(HttpCode::HTTP_BAD_REQUEST);
            $response->setErrors($this->validator->getErrors());
            $presenter->present($response);
            return;
        }

        $user = $this->userRepository->findOneByEmail($request->email);
        if (!$user || !$this->passwordHasher->verify($request->password, $user->getPassword())) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_FORBIDDEN);
            $response->setMessage('Invalid email or password.');
            $presenter->present($response);
            return;
        }

        $response->setStatus(true);
        $response->setMessage('Login successful.');
        $response->setUser($user);
        $presenter->present($response);

    }

}