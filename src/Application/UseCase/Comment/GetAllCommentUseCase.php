<?php

namespace Application\UseCase\Comment;

use Application\Presenter\GetAllCommentPresenterInterface;
use Application\Request\Comment\GetAllCommentRequest;
use Application\Response\GetAllCommentResponse;
use Application\Service\HttpCode;
use Domain\Repository\CommentRepositoryInterface;

readonly class GetAllCommentUseCase
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository
    ){}

    public function execute(
        GetAllCommentRequest $request,
        GetAllCommentPresenterInterface $presenter
    ): void {

        $comments = null;

        if ($request->userId) {
            $comments = $this->commentRepository->findByUser($request->userId);
        }
        if ($request->postId) {
            $comments = $this->commentRepository->findByPost($request->postId);
        }
        if (!$comments) {
            $comments = $this->commentRepository->findAll();
        }

        $response = new GetAllCommentResponse();

        $response->setHttpCode(HttpCode::HTTP_OK);
        $response->setComments($comments);

        $presenter->present($response);

    }
}