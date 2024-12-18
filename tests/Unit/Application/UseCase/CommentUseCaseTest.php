<?php

use Application\Request\Comment\CreateCommentRequest;
use Application\UseCase\Comment\CreateCommentUseCase;
use Application\Validator\Comment\CreateCommentValidator;
use Domain\Entity\Post;
use Domain\Entity\User;
use Presentation\Comment\ShowCommentJsonPresenter;
use Tests\Unit\Mock\Repository\InMemoryCommentRepository;
use Tests\Unit\Mock\Repository\InMemoryPostRepository;
use Tests\Unit\Mock\Repository\InMemoryUserRepository;

beforeEach(function () {

    $this->commentRepository = new InMemoryCommentRepository();
    $this->userRepository = new InMemoryUserRepository();
    $this->postRepository = new InMemoryPostRepository();
    $this->presenter = new ShowCommentJsonPresenter();

});

it('should add a comment', function () {

    $user = new User();
    $user->setUsername('viper');
    $user->setEmail('viper@gmail.com');
    $this->userRepository->save($user);

    $post = new Post();
    $post->setTitle('title');
    $post->setContent('content');
    $post->setUser($user);
    $this->postRepository->save($post);

    $useCase = new CreateCommentUseCase(
        $this->commentRepository,
        $this->postRepository,
        $this->userRepository,
        new CreateCommentValidator()
    );

    $request = new CreateCommentRequest(
        'Good. Thank you',
        $user->getId(),
        $post->getId()
    );

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    $comment = $this->commentRepository->find($viewModel->data['id']);
    expect($comment)->not()->toBeNull()
        ->and($comment->getContent())->toBe($request->content)
        ->and($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(201)
        ->and($viewModel->data['content'])->toBe($request->content)
        ->and($viewModel->data['user']['id'])->toBe($request->userId)
        ->and($viewModel->data['post']['id'])->toBe($request->postId);

});


it('should return errors if user or post not found (creation)', function () {

    $useCase = new CreateCommentUseCase(
        $this->commentRepository,
        $this->postRepository,
        $this->userRepository,
        new CreateCommentValidator()
    );

    $request = new CreateCommentRequest(
        'content',
        'invalid_user',
        'invalid_post'
    );

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeFalse()
        ->and($viewModel->httpCode)->toBe(404)
        ->and($viewModel->errors)->not()->toBeEmpty()
        ->and($viewModel->data)->toBeEmpty();
});