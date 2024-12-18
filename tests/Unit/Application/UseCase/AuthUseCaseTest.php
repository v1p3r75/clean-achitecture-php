<?php


use Application\Request\Auth\LoginRequest;
use Application\UseCase\Auth\LoginUseCase;
use Application\Validator\Auth\LoginValidator;
use Domain\Entity\User;
use Presentation\User\ShowUserJsonPresenter;
use Tests\Unit\Mock\Repository\InMemoryUserRepository;
use Tests\Unit\Mock\Service\PasswordHasher;

beforeEach(function () {
    $this->userRepository = new InmemoryUserRepository();
    $this->hasher = new PasswordHasher();
    $this->presenter = new ShowUserJsonPresenter();
});

it('should authenticate user', function () {

    $user = new User();
    $user->setEmail('viper@test.com');
    $user->setUsername('viper');
    $user->setPassword($this->hasher->hash('password'));

    $this->userRepository->save($user);

    $useCase = new LoginUseCase(
        $this->userRepository,
        $this->hasher,
        new LoginValidator()
    );
    $request = new LoginRequest('viper@test.com', 'password');

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->data['email'])->toBe($request->email)
        ->and($viewModel->data['username'])->toBe('viper');
});

it('should return the errors if credentials are invalid', function () {

    $user = new User();
    $user->setEmail('viper@test.com');
    $user->setUsername('viper');
    $user->setPassword($this->hasher->hash('password'));

    $this->userRepository->save($user);

    $useCase = new LoginUseCase(
        $this->userRepository,
        $this->hasher,
        new LoginValidator()
    );
    $request = new LoginRequest('invalid@test.com', 'invalid');

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeFalse()
        ->and($viewModel->httpCode)->toBe(403)
        ->and($viewModel->data)->toBeEmpty();
});