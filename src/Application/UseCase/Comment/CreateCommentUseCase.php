<?php

namespace Application\UseCase\Comment;

use Application\Contract\ValidatorInterface;
use Application\Presenter\ShowCommentPresenterInterface;
use Application\Request\Comment\CreateCommentRequest;
use Application\Response\CommentResponse;
use Application\Service\HttpCode;
use DateTimeImmutable;
use Domain\Entity\Comment;
use Domain\Repository\CommentRepositoryInterface;
use Domain\Repository\PostRepositoryInterface;
use Domain\Repository\UserRepositoryInterface;

readonly class CreateCommentUseCase
{

    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private PostRepositoryInterface $postRepository,
        private UserRepositoryInterface $userRepository,
        private ValidatorInterface $validator
    ) {}

    public function execute(CreateCommentRequest $request, ShowCommentPresenterInterface $presenter): void
    {

        $response = new CommentResponse();

        if (!$this->validator->validate($request)) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_BAD_REQUEST);
            $response->setErrors($this->validator->getErrors());
            $presenter->present($response);
            return;
        }

        $user = $this->userRepository->find($request->userId);
        $post = $this->postRepository->find($request->postId);

        if (!$user || !$post) {
            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $response->setMessage('Not found');
            !$user ?
                $response->addError('user', 'user not found') :
                $response->addError('post', 'post not found');

            $presenter->present($response);
            return;
        }

        $comment = new Comment();
        $comment->setContent($request->content);
        $comment->setUser($user);
        $comment->setPost($post);
        $comment->setCreatedAt(new DateTimeImmutable());

        $this->commentRepository->save($comment);

        $response->setHttpCode(HttpCode::HTTP_CREATED);
        $response->setComment($comment);

        $presenter->present($response);
    }

}