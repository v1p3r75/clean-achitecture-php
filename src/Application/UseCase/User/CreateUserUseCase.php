<?php

namespace Application\UseCase\User;

use Application\Contract\PasswordHasherInterface;
use Application\Presenter\ShowUserPresenterInterface;
use Application\Request\User\CreateUserRequest;
use Application\Response\UserResponse;
use Application\Service\HttpCode;
use Assert\Assert;
use Assert\LazyAssertionException;
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
        CreateUserRequest          $request,
        ShowUserPresenterInterface $presenter,
    ): void
    {

        $response = new UserResponse();

        if (!$this->isValidRequest($request, $response)) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_BAD_REQUEST);
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

    private function isValidRequest(CreateUserRequest $request, UserResponse $response): bool
    {
        try {

            Assert::lazy()
                ->that($request->email, 'email')->email()
                ->that($request->username, 'username')->minLength(4)
                ->that($request->password, 'password')->minLength(8)
                ->verifyNow();

            return true;

        } catch (LazyAssertionException $e) {

            $errors = $e->getErrorExceptions();
            foreach ($errors as $error) {
                $response->addError($error->getPropertyPath(), $error->getMessage());
            }
            return false;
        }

    }

}
