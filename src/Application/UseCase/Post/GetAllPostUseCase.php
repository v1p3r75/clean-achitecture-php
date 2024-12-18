<?php

namespace Application\UseCase\Post;

use Application\Presenter\GetAllPostPresenterInterface;
use Application\Request\Post\GetAllPostRequest;
use Application\Response\GetAllPostResponse;
use Application\Service\HttpCode;
use Domain\Repository\PostRepositoryInterface;

readonly class GetAllPostUseCase
{
    public function __construct(
        private PostRepositoryInterface $postRepository
    ){}

    public function execute(
        GetAllPostRequest $request,
        GetAllPostPresenterInterface $presenter
    ): void {

        if ($request->userId) {
             $posts = $this->postRepository->getByUser($request->userId);
        } else {
            $posts = $this->postRepository->findAll();
        }

        $response = new GetAllPostResponse();

        $response->setHttpCode(HttpCode::HTTP_OK);
        $response->setPosts($posts);

        $presenter->present($response);

    }
}