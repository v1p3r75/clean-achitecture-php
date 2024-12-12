<?php

use Domain\User\UseCase\Create\CreateUserRequest;
use Domain\User\UseCase\Create\CreateUserUseCase;
use Tests\Unit\Domain\User\Adapters\CreateUserPresenterJson;
use Tests\Unit\Domain\User\Adapters\InMemoryUserRepositoryAdapter;

it ('should create a new user', function () {

    $repository = new InMemoryUserRepositoryAdapter();
    $presenter = new CreateUserPresenterJson();

    $useCase = new CreateUserUseCase($repository);
    $request = new CreateUserRequest(
        'viper75',
        'passme',
        'viper75@gmail.com'
    );

    $data = $useCase->execute($request, $presenter);

    expect($data)->toBe([]);

});