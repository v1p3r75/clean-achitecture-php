<?php

use Application\Request\Post\CreatePostRequest;
use Application\Request\Post\DeletePostRequest;
use Application\Request\Post\GetAllPostRequest;
use Application\Request\Post\GetPostRequest;
use Application\Request\Post\UpdatePostRequest;
use Application\UseCase\Post\CreatePostUseCase;
use Application\UseCase\Post\DeletePostUseCase;
use Application\UseCase\Post\GetAllPostUseCase;
use Application\UseCase\Post\GetPostUseCase;
use Application\UseCase\Post\UpdatePostUseCase;
use Application\Validator\Post\CreatePostValidator;
use Application\Validator\Post\UpdatePostValidator;
use Domain\Entity\Post;
use Domain\Entity\User;
use Presentation\Post\DeletePostJsonPresenter;
use Presentation\Post\GetAllPostJsonPresenter;
use Presentation\Post\ShowPostJsonPresenter;
use Tests\Unit\Mock\Repository\InMemoryPostRepository;
use Tests\Unit\Mock\Repository\InMemoryUserRepository;

beforeEach(function () {

    $this->userRepository = new InMemoryUserRepository();
    $this->postRepository = new InMemoryPostRepository();
    $this->presenter = new ShowPostJsonPresenter();

});

it('should post an article', function () {

    $fakeUser = new User();
    $fakeUser->setUsername('viper');
    $fakeUser->setEmail('viper@gmail.com');
    $this->userRepository->save($fakeUser);

    $useCase = new CreatePostUseCase(
        $this->postRepository,
        $this->userRepository,
        new CreatePostValidator()
    );

    $request = new CreatePostRequest(
        'Clean Architecture',
        'How to develop a clean architecture project ?',
        $fakeUser->getId()
    );

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    $post = $this->postRepository->find($viewModel->data['id']);
    expect($post)->not()->toBeNull()
        ->and($post->getTitle())->toBe($request->title)
        ->and($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(201)
        ->and($viewModel->data['title'])->toBe($request->title)
        ->and($viewModel->data['content'])->toBe($request->content)
        ->and($viewModel->data['user']['id'])->toBe($request->userId);

});


it('should return validation errors for invalid request (creation)', function () {

    $useCase = new CreatePostUseCase(
        $this->postRepository,
        $this->userRepository,
        new CreatePostValidator()
    );

    $request = new CreatePostRequest(
        'title',
        'content',
        'user'
    );

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeFalse()
        ->and($viewModel->httpCode)->toBe(400)
        ->and($viewModel->errors)->not()->toBeEmpty()
        ->and($viewModel->data)->toBeEmpty();

});

it('should return errors if user not found', function () {

    $useCase = new CreatePostUseCase(
        $this->postRepository,
        $this->userRepository,
        new CreatePostValidator()
    );

    $request = new CreatePostRequest(
        'title',
        'Title content. Long text.',
        'invalid_user'
    );

    $useCase->execute($request, $this->presenter);

    $post = $this->postRepository->find($request->userId);
    expect($post)->toBeNull();

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeFalse()
        ->and($viewModel->httpCode)->toBe(404)
        ->and($viewModel->errors)->not()->toBeEmpty()
        ->and($viewModel->data)->toBeEmpty();

});

it ('should get a post from repository', function () {

    $fakeUser = new User();
    $fakeUser->setEmail('fake@gmail.com');
    $fakeUser->setUsername('viper');
    $fakeUser->setPassword('password');

    $post = new Post();
    $post->setTitle('title');
    $post->setContent('content');
    $post->setUser($fakeUser);

    $this->postRepository->save($post);

    $useCase = new GetPostUseCase($this->postRepository);

    $request = new GetPostRequest($post->getId());

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->tobeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data['title'])->toBe('title')
        ->and($viewModel->data['content'])->toBe('content')
        ->and($viewModel->data['user']['username'])->toBe('viper');
});


it ('should return errors if post not found', function () {

    $useCase = new GetPostUseCase($this->postRepository);

    $request = new GetPostRequest('unknown-post');

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeFalse()
        ->and($viewModel->httpCode)->toBe(404)
        ->and($viewModel->errors)->toBeEmpty();

});


it ('should return all posts', closure: function () {

    $post1 = new Post();
    $post1->setTitle('title');
    $post2 = new Post();
    $post2->setTitle('title_2');

    $this->postRepository->save($post1);
    $this->postRepository->save($post2);

    $useCase = new GetAllPostUseCase($this->postRepository);
    $request = new GetAllPostRequest();
    $presenter = new GetAllPostJsonPresenter();

    $useCase->execute($request, $presenter);

    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data)->toHaveCount(2);
});

it ('should update a post', closure: function () {

    $user = new User();
    $user->setEmail('fake@gmail.com');
    $user->setUsername('viper');
    $user->setPassword('password');

    $post = new Post();
    $post->setTitle('title');
    $post->setContent('content');
    $post->setUser($user);

    $this->postRepository->save($post);

    $useCase = new UpdatePostUseCase(
        $this->postRepository,
        new UpdatePostValidator()
    );

    $request = new UpdatePostRequest(
        $post->getId(),
        'new_title',
    );

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->tobeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data['title'])->toBe('new_title')
        ->and($viewModel->data['content'])->toBe('content');
});

it ('should delete a post', closure: function () {

    $post = new Post();
    $post->setTitle('title');

    $this->postRepository->save($post);

    $useCase = new DeletePostUseCase($this->postRepository);
    $request = new DeletePostRequest($post->getId());
    $presenter = new DeletePostJsonPresenter();

    $useCase->execute($request, $presenter);

    expect($this->postRepository->find($request->id))->toBeNull();

    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(204);

});

it ('should get posts by user', closure: function () {

    $user = new User();
    $user->setEmail('fake@gmail.com');
    $user->setUsername('viper');

    $user2 = new User();
    $user2->setEmail('fake@gmail.com');
    $user2->setUsername('viper');

    $post1 = new Post();
    $post1->setTitle('title');
    $post1->setUser($user);

    $post2 = new Post();
    $post2->setTitle('title_2');
    $post2->setUser($user);

    $post3 = new Post();
    $post3->setTitle('title_3');
    $post3->setUser($user2);

    $this->postRepository->save($post1);
    $this->postRepository->save($post2);
    $this->postRepository->save($post3);

    $useCase = new GetAllPostUseCase($this->postRepository);
    $request = new GetAllPostRequest($user->getId());
    $presenter = new GetAllPostJsonPresenter();

    $useCase->execute($request, $presenter);

    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data)->toHaveCount(2);
});