<?php

namespace Application\UseCase\Post;

use Application\Presenter\DeletePostPresenterInterface;
use Application\Request\Post\DeletePostRequest;
use Application\Response\BaseResponse;
use Application\Service\HttpCode;
use Domain\Repository\PostRepositoryInterface;

readonly class DeletePostUseCase
{

    public function __construct(
        private PostRepositoryInterface $postRepository
    ){}

    public function execute(
        DeletePostRequest $request,
        DeletePostPresenterInterface $presenter
    ): void {

        $post = $this->postRepository->find($request->id);

        $response = new BaseResponse();

        if (!$post) {

            $response->setStatus(false);
            $response->setMessage('post not found');
            $response->setHttpCode(HttpCode::HTTP_NOT_FOUND);
            $presenter->present($response);
            return;
        }

        $this->postRepository->delete($request->id);

        $response->setHttpCode(HttpCode::HTTP_NO_CONTENT);
        $response->setMessage('post deleted');
        $presenter->present($response);

    }
}