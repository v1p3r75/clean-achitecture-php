<?php

namespace Application\UseCase\Post;

use Application\Presenter\ShowPostPresenterInterface;
use Application\Request\Post\GetPostRequest;
use Application\Response\PostResponse;
use Application\Service\HttpCode;
use Domain\Repository\CommentRepositoryInterface;
use Domain\Repository\PostRepositoryInterface;

readonly class GetPostUseCase
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private CommentRepositoryInterface $commentRepository
    ){}

    public function execute(
        GetPostRequest $request,
        ShowPostPresenterInterface $presenter
    ): void {

        $post = $this->postRepository->find($request->id);

        $response = new PostResponse();

        if (!$post) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $presenter->present($response);
            return;
        }

        $comments = $this->commentRepository->findByPost($post->getId());
        $post->setComments($comments);

        $response->setHttpCode(HttpCode::HTTP_OK);
        $response->setPost($post);

        $presenter->present($response);

    }
}