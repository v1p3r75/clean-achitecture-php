<?php

namespace Application\UseCase\Comment;

use Application\Presenter\ShowCommentPresenterInterface;
use Application\Request\Comment\GetCommentRequest;
use Application\Response\CommentResponse;
use Application\Service\HttpCode;
use Domain\Repository\CommentRepositoryInterface;

readonly class GetCommentUseCase
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository
    ){}

    public function execute(
        GetCommentRequest $request,
        ShowCommentPresenterInterface $presenter
    ): void {

        $comment = $this->commentRepository->find($request->id);

        $response = new CommentResponse();

        if (!$comment) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $presenter->present($response);
            return;
        }

        $response->setHttpCode(HttpCode::HTTP_OK);
        $response->setComment($comment);

        $presenter->present($response);

    }
}