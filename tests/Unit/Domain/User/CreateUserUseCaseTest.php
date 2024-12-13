<?php

use Domain\User\UseCase\Create\CreateUserRequest;
use Domain\User\UseCase\Create\CreateUserUseCase;
use Tests\Unit\Domain\User\Adapters\CreateUserPresenterJson;
use Tests\Unit\Domain\User\Adapters\InMemoryUserRepository;

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
