<?php

use Application\Contract\PasswordHasherInterface;
use Application\UseCase\User\CreateUserUseCase;
use Application\Request\User\CreateUserRequest;
use Presentation\User\ShowUserJsonPresenter;
use Tests\Unit\Mock\Repository\InMemoryUserRepository;

beforeEach(function () {

    $this->repository = new InMemoryUserRepository();
    $this->presenter = new ShowUserJsonPresenter();
    $this->hasher = Mockery::mock(PasswordHasherInterface::class);
    $this->hasher->shouldReceive("hash")->andReturn('password');

});

it('should create a new user', function () {

    $useCase = new CreateUserUseCase($this->repository, $this->hasher);

    $request = new CreateUserRequest(
        'viper75',
        'Passme123#',
        'viper75@gmail.com'
    );

    $useCase->execute($request, $this->presenter);

    $savedUser = $this->repository->findOneByEmail($request->email);
    expect($savedUser)->not()->toBeNull();
    expect($savedUser->getUsername())->toBe($request->username);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeTrue();
    expect($viewModel->httpCode)->toBe(201);
    expect($viewModel->data['email'])->toBe($request->email);
    expect($viewModel->data['username'])->toBe($request->username);
    expect($viewModel->data['isAdmin'])->toBeFalse();

});

it('should return validation errors for user creation', function () {

    $useCase = new CreateUserUseCase($this->repository, $this->hasher);

    $request = new CreateUserRequest(
        'min',
        'passme',
        'invalid_address'
    );

    $useCase->execute($request, $this->presenter);

    $savedUser = $this->repository->findOneByEmail($request->email);
    expect($savedUser)->toBeNull();

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeFalse();
    expect($viewModel->httpCode)->toBe(400);
    expect($viewModel->errors)->not()->toBeEmpty();
    expect($viewModel->data)->toBeEmpty();
});
