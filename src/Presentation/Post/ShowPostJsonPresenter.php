<?php

namespace Presentation\Post;

use Application\Presenter\ShowPostPresenterInterface;
use Application\Response\PostResponse;
use Presentation\Post\ViewModel\ShowPostViewModel;

class ShowPostJsonPresenter implements ShowPostPresenterInterface
{

    private ?ShowPostViewModel $viewModel = null;

    public function present(PostResponse $response): void
    {
        $this->viewModel = new ShowPostViewModel();
        $this->viewModel->status = $response->getStatus();
        $this->viewModel->httpCode = $response->getHttpCode();
        $this->viewModel->message = $response->getMessage();
        $this->viewModel->errors = $response->getErrors();
        if ($post = $response->getPost()) {
            $this->viewModel->data = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'user' => [
                    'id' => $post->getUser()->getId(),
                    'username' => $post->getUser()->getUsername()
                ],
                'createdAt' => $post->getPublishedAt()?->format("Y-m-d"),
            ];
        }
    }

    /**
     * @return ShowPostViewModel|null
     */
    public function getViewModel(): ?ShowPostViewModel
    {
        return $this->viewModel;
    }

}