<?php

use Application\Contract\PasswordHasherInterface;
use Application\UseCase\User\CreateUserUseCase;
use Application\Request\User\CreateUserRequest;
use Domain\Repository\UserRepositoryInterface;
use Presentation\User\ShowUserJsonPresenter;

it('should create a new user', function () {

    $repository = Mockery::mock(UserRepositoryInterface::class);
    $repository->shouldReceive("save");

    $hasher = Mockery::mock(PasswordHasherInterface::class);
    $hasher->shouldReceive("hash")->andReturn('password_hashed');

    $useCase = new CreateUserUseCase($repository, $hasher);

    $request = new CreateUserRequest(
        'viper75',
        'passme',
        'viper75@gmail.com'
    );
    $presenter = new ShowUserJsonPresenter();

    $useCase->execute($request, $presenter);

    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue();
    expect($viewModel->data['email'])->toBe('viper75@gmail.com');
    expect($viewModel->data['username'])->toBe('viper75');
    expect($viewModel->data['isAdmin'])->toBeFalse();


});
