<?php

namespace Application\UseCase\Comment;

use Application\Presenter\DeleteCommentPresenterInterface;
use Application\Request\Comment\DeleteCommentRequest;
use Application\Response\BaseResponse;
use Application\Service\HttpCode;
use Domain\Repository\CommentRepositoryInterface;

readonly class DeleteCommentUseCase
{

    public function __construct(
        private CommentRepositoryInterface $commentRepository,
    ){}

    public function execute(
        DeleteCommentRequest $request,
        DeleteCommentPresenterInterface $presenter
    ): void {

        $comment = $this->commentRepository->find($request->id);

        $response = new BaseResponse();

        if (!$comment) {

            $response->setStatus(false);
            $response->setMessage('post not found');
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $presenter->present($response);
            return;
        }

        $this->commentRepository->delete($request->id);

        $response->setHttpCode(HttpCode::HTTP_NO_CONTENT);
        $response->setMessage('post deleted');
        $presenter->present($response);

    }
}