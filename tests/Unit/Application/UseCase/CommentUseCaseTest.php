<?php

use Application\Request\Comment\CreateCommentRequest;
use Application\Request\Comment\DeleteCommentRequest;
use Application\Request\Comment\GetAllCommentRequest;
use Application\Request\Comment\GetCommentRequest;
use Application\Request\Comment\UpdateCommentRequest;
use Application\UseCase\Comment\CreateCommentUseCase;
use Application\UseCase\Comment\DeleteCommentUseCase;
use Application\UseCase\Comment\GetAllCommentUseCase;
use Application\UseCase\Comment\GetCommentUseCase;
use Application\UseCase\Comment\UpdateCommentUseCase;
use Application\Validator\Comment\CreateCommentValidator;
use Application\Validator\Comment\UpdateCommentValidator;
use Domain\Entity\Comment;
use Domain\Entity\Post;
use Domain\Entity\User;
use Presentation\Comment\DeleteCommentJsonPresenter;
use Presentation\Comment\GetAllCommentJsonPresenter;
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

it ('should get a comment', function () {

    $user = new User();
    $user->setEmail('fake@gmail.com');
    $user->setUsername('viper');

    $post = new Post();
    $post->setTitle('title');
    $post->setContent('content');
    $post->setUser($user);

    $comment = new Comment();
    $comment->setContent('content');
    $comment->setUser($user);
    $comment->setPost($post);
    $this->commentRepository->save($comment);

    $useCase = new GetCommentUseCase($this->commentRepository);

    $request = new GetCommentRequest($comment->getId());

    $useCase->execute($request, $this->presenter);

    expect($this->commentRepository->find($request->id))->not()->toBeNull();

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->tobeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data['content'])->toBe('content')
        ->and($viewModel->data['user']['username'])->toBe('viper')
        ->and($viewModel->data['post']['title'])->toBe('title');
});

it ('should return errors if comment not found', function () {

    $useCase = new GetCommentUseCase($this->commentRepository);

    $request = new GetCommentRequest('invalid_id');

    $useCase->execute($request, $this->presenter);

    expect($this->commentRepository->find($request->id))->toBeNull();

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->toBeFalse()
        ->and($viewModel->httpCode)->toBe(404)
        ->and($viewModel->data)->toBeEmpty();
});

it ('should return all comments', closure: function () {

    $comment = new Comment();
    $comment->setContent('content');
    $comment->setUser(new User());
    $comment->setPost(new Post());

    $comment2 = new Comment();
    $comment2->setContent('content_2');
    $comment2->setUser(new User());
    $comment2->setPost(new Post());

    $this->commentRepository->save($comment);
    $this->commentRepository->save($comment2);

    $useCase = new GetAllCommentUseCase($this->commentRepository);

    $request = new GetAllCommentRequest();
    $presenter = new GetAllCommentJsonPresenter();

    $useCase->execute($request, $presenter);

    expect($this->commentRepository->findAll())->toHaveCount(2);
    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data)->toHaveCount(2);
});

it ('should get comments by post', closure: function () {

    $post1 = new Post();
    $post2 = new Post();

    $comment1 = new Comment();
    $comment1->setPost($post1);
    $comment1->setUser(new User());

    $comment2 = new Comment();
    $comment2->setPost($post1);
    $comment2->setUser(new User());

    $comment3 = new Comment();
    $comment3->setPost($post2);
    $comment3->setUser(new User());


    $this->commentRepository->save($comment1);
    $this->commentRepository->save($comment2);
    $this->commentRepository->save($comment3);

    $useCase = new GetAllCommentUseCase($this->commentRepository);

    $request = new GetAllCommentRequest(
        postId: $post1->getId()
    );
    $presenter = new GetAllCommentJsonPresenter();

    $useCase->execute($request, $presenter);

    expect($this->commentRepository->findAll())->toHaveCount(3);
    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data)->toHaveCount(2);
});

it ('should get comments by user', closure: function () {

    $user1 = new User();
    $user2 = new User();

    $comment1 = new Comment();
    $comment1->setPost(new Post());
    $comment1->setUser($user1);

    $comment2 = new Comment();
    $comment2->setPost(new Post());
    $comment2->setUser($user1);

    $comment3 = new Comment();
    $comment3->setPost(new Post());
    $comment3->setUser($user2);


    $this->commentRepository->save($comment1);
    $this->commentRepository->save($comment2);
    $this->commentRepository->save($comment3);

    $useCase = new GetAllCommentUseCase($this->commentRepository);

    $request = new GetAllCommentRequest(
        userId: $user1->getId()
    );
    $presenter = new GetAllCommentJsonPresenter();

    $useCase->execute($request, $presenter);

    expect($this->commentRepository->findAll())->toHaveCount(3);
    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data)->toHaveCount(2);
});

it ('should update a comment', closure: function () {

    $user = new User();
    $user->setEmail('fake@gmail.com');
    $user->setUsername('viper');

    $post = new Post();
    $post->setTitle('title');
    $post->setContent('content');
    $post->setUser($user);

    $comment = new Comment();
    $comment->setContent('content');
    $comment->setUser($user);
    $comment->setPost($post);

    $this->commentRepository->save($comment);

    $useCase = new UpdateCommentUseCase(
        $this->commentRepository,
        new UpdateCommentValidator()
    );

    $request = new UpdateCommentRequest(
        $comment->getId(),
        'new_content',
    );

    $useCase->execute($request, $this->presenter);

    $viewModel = $this->presenter->getViewModel();

    expect($viewModel->status)->tobeTrue()
        ->and($viewModel->httpCode)->toBe(200)
        ->and($viewModel->errors)->toBeEmpty()
        ->and($viewModel->data['content'])->toBe('new_content');
});

it('should delete a comment', function () {

    $comment = new Comment();
    $comment->setContent('content');
    $comment->setUser(new User());
    $comment->setPost(new Post());

    $this->commentRepository->save($comment);

    $useCase = new DeleteCommentUseCase($this->commentRepository);
    $request = new DeleteCommentRequest($comment->getId());
    $presenter = new DeleteCommentJsonPresenter();

    $useCase->execute($request, $presenter);

    expect($this->postRepository->find($request->id))->toBeNull();

    $viewModel = $presenter->getViewModel();

    expect($viewModel->status)->toBeTrue()
        ->and($viewModel->httpCode)->toBe(204);
});