<?php

namespace Application\UseCase\Post;

use Application\Presenter\ShowPostPresenterInterface;
use Application\Request\Post\CreatePostRequest;
use Application\Response\PostResponse;
use Application\Service\HttpCode;
use Application\Validator\Post\CreatePostValidator;
use Assert\Assert;
use Assert\LazyAssertionException;
use DateTimeImmutable;
use Domain\Entity\Post;
use Domain\Repository\PostRepositoryInterface;
use Domain\Repository\UserRepositoryInterface;

readonly class CreatePostUseCase
{

    public function __construct(
        private PostRepositoryInterface $postRepository,
        private UserRepositoryInterface $userRepository,
        private CreatePostValidator $validator
    ) {}

    public function execute(CreatePostRequest $request, ShowPostPresenterInterface $presenter): void
    {

        $response = new PostResponse();

        if (!$this->validator->validate($request)) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_BAD_REQUEST);
            $response->setErrors($this->validator->getErrors());
            $presenter->present($response);
            return;
        }

        $user = $this->userRepository->find($request->userId);

        if (!$user) {
            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $response->setMessage('Not found');
            $response->addError('user', 'user not found');
            $presenter->present($response);
            return;
        }

        $post = new Post();
        $post->setTitle($request->title);
        $post->setContent($request->content);
        $post->setUser($user);
        $user->setCreatedAt(new DateTimeImmutable());

        $this->postRepository->save($post);

        $response->setHttpCode(HttpCode::HTTP_CREATED);
        $response->setPost($post);

        $presenter->present($response);
    }

}