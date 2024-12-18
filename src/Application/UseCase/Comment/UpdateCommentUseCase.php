<?php

namespace Application\UseCase\Comment;

use Application\Contract\ValidatorInterface;
use Application\Presenter\ShowCommentPresenterInterface;
use Application\Request\Comment\UpdateCommentRequest;
use Application\Response\CommentResponse;
use Application\Service\HttpCode;
use Domain\Repository\CommentRepositoryInterface;

readonly class UpdateCommentUseCase
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private ValidatorInterface $validator
    ) {}

    public function execute(
        UpdateCommentRequest          $request,
        ShowCommentPresenterInterface $presenter,
    ): void
    {

        $response = new CommentResponse();

        if (!$this->validator->validate($request)) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_BAD_REQUEST);
            $response->setErrors($this->validator->getErrors());
            $presenter->present($response);
            return;
        }

        $comment = $this->commentRepository->find($request->id);

        if(!$comment) {
            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $presenter->present($response);
            return;
        }

        if ($request->content) {
            $comment->setContent($request->content);
        }

        $this->commentRepository->save($comment);

        $response->setHttpCode(HttpCode::HTTP_OK);
        $response->setComment($comment);

        $presenter->present($response);
    }

}
