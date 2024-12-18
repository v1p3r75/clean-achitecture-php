<?php

namespace Application\UseCase\Post;

use Application\Contract\ValidatorInterface;
use Application\Presenter\ShowPostPresenterInterface;
use Application\Request\Post\UpdatePostRequest;
use Application\Response\PostResponse;
use Application\Service\HttpCode;
use Domain\Repository\PostRepositoryInterface;

readonly class UpdatePostUseCase
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private ValidatorInterface $validator
    ) {}

    public function execute(
        UpdatePostRequest          $request,
        ShowPostPresenterInterface $presenter,
    ): void
    {

        $response = new PostResponse();

        if (!$this->validator->validate($request)) {

            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_BAD_REQUEST);
            $response->setErrors($this->validator->getErrors());
            $presenter->present($response);
            return;
        }

        $post = $this->postRepository->find($request->id);

        if(!$post) {
            $response->setStatus(false);
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $presenter->present($response);
            return;
        }

        if ($request->title) {
            $post->setTitle($request->title);
        }
        if ($request->content) {
            $post->setContent($request->content);
        }

        $this->postRepository->save($post);

        $response->setHttpCode(HttpCode::HTTP_OK);
        $response->setPost($post);

        $presenter->present($response);
    }

}
