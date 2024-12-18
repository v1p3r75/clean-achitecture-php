<?php

use Application\Contract\PasswordHasherInterface;
use Application\Request\User\CreateUserRequest;
use Application\Request\User\DeleteUserRequest;
use Application\Request\User\GetAllUserRequest;
use Application\Request\User\GetUserRequest;
use Application\UseCase\User\CreateUserUseCase;
use Application\UseCase\User\DeleteUserUseCase;
use Application\UseCase\User\GetAllUserUseCase;
use Application\UseCase\User\GetUserUseCase;
use Application\Validator\User\CreateUserValidator;
use Domain\Entity\User;
use Presentation\User\DeleteUserJsonPresenter;
use Presentation\User\GetAllUserJsonPresenter;
use Presentation\User\ShowUserJsonPresenter;
use Tests\Unit\Mock\Repository\InMemoryUserRepository;

beforeEach(function () {

    $this->repository = new InMemoryUserRepository();
    $this->presenter = new ShowUserJsonPresenter();
    $this->hasher = Mockery::mock(PasswordHasherInterface::class);
    $this->hasher->shouldReceive("hash")->andReturn('password');

});

it('should create a new user', function () {

    $useCase = new CreateUserUseCase(
        $this->repository,
        $this->hasher,
        new CreateUserValidator()
    );

    $request = new CreateUserRequest(
        'viper75',
        'Passme123#',
        'viper75@gmail.com'
    );

    $useCase->execute($request, $this->presenter);

    $savedUser = $this->repository->findOneByEmail($request->email);
    expect($savedUser)->not()->toBeNull()
        ->and($savedUser->getUsername())->toBe($request->username);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(201)
        ->and($viewModel->data['email'])->toBe($request->email)
        ->and($viewModel->data['username'])->toBe($request->username)
        ->and($viewModel->data['isAdmin'])->toBeFalse();

});

it('should return validation errors for invalid request (creation)', function () {

    $useCase = new CreateUserUseCase(
        $this->repository,
        $this->hasher,
        new CreateUserValidator()
    );

    $request = new CreateUserRequest(
        'min',
        'passme',
        'invalid_address'
    );

    $useCase->execute($request, $this->presenter);

    $savedUser = $this->repository->findOneByEmail($request->email);
    expect($savedUser)->toBeNull();

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeFalse()
        ->and($viewModel->httpCode)->toBe(400)
        ->and($viewModel->errors)->not()->toBeEmpty()
        ->and($viewModel->data)->toBeEmpty();
});

it ('should get user from repository', function () {

    $fakeUser = new User();
    $fakeUser->setEmail('fake@gmail.com');
    $fakeUser->setUsername('viper');
    $fakeUser->setPassword('password');

    $this->repository->save($fakeUser);

    $useCase = new GetUserUseCase($this->repository);

    $request = new GetUserRequest($fakeUser->getId());

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->tobeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data['email'])->toBe('fake@gmail.com')
        ->and($viewModel->data['username'])->toBe('viper');
});

it ('should return errors if user not found', function () {

    $useCase = new GetUserUseCase($this->repository);

    $request = new GetUserRequest('unknown-user');

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeFalse()
        ->and($viewModel->httpCode)->toBe(404)
        ->and($viewModel->errors)->toBeEmpty();

});

it ('should return all users', closure: function () {

    $fakeUser1 = new User();
    $fakeUser1->setEmail('user1@gmail.com');
    $fakeUser2 = new User();
    $fakeUser2->setEmail('user2@gmail.com');

    $this->repository->save($fakeUser1);
    $this->repository->save($fakeUser2);

    $useCase = new GetAllUserUseCase($this->repository);
    $request = new GetAllUserRequest();
    $presenter = new GetAllUserJsonPresenter();

    $useCase->execute($request, $presenter);

    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data)->toHaveCount(2);
});


it ('should delete a user', closure: function () {

    $fakeUser = new User();
    $fakeUser->setEmail('user1@gmail.com');

    $this->repository->save($fakeUser);

    $useCase = new DeleteUserUseCase($this->repository);
    $request = new DeleteUserRequest($fakeUser->getId());
    $presenter = new DeleteUserJsonPresenter();

    $useCase->execute($request, $presenter);

    expect($this->repository->find($request->id))->toBeNull();

    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(204);

});