<?php

use Application\UseCase\User\CreateUserUseCase;
use Application\Request\User\CreateUserRequest;

it('should create a new user', function () {

    $repository = new InMemoryUserRepository();
    $presenter = new CreateUserPresenterJson();

    $useCase = new CreateUserUseCase($repository);

    $request = new CreateUserRequest(
        'viper75',
        'passme',
        'viper75@gmail.com'
    );

    $return = $useCase->execute($request, $presenter);

    $data = [
        'username' => 'viper75',
        'email' => 'viper75@gmail.com',
    ];

    expect($return)->toBe(json_encode($data));
});

it('should return all users', function () {

    $repository = new InMemoryUserRepository();
    $presenter = new CreateUserPresenterJson();
    $useCase = new CreateUserUseCase($repository);

    $request = new CreateUserRequest(
        'viper75',
        'passme',
        'viper75@gmail.com'
    );

    $return = $useCase->execute($request, $presenter);

    $data = [
        'username' => 'viper75',
        'email' => 'viper75@gmail.com',
    ];

    expect($return)->toBe(json_encode($data));
});
