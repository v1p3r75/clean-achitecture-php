<?php

namespace Presentation\Post;

use Application\Presenter\GetAllPostPresenterInterface;
use Application\Response\GetAllPostResponse;
use Presentation\Post\ViewModel\GetAllPostViewModel;

class GetAllPostJsonPresenter implements GetAllPostPresenterInterface
{

    private ?GetAllPostViewModel $viewModel = null;

    public function present(GetAllPostResponse $response): void
    {
        $this->viewModel = new GetAllPostViewModel();
        $this->viewModel->status = $response->getStatus();
        $this->viewModel->httpCode = $response->getHttpCode();
        $this->viewModel->message = $response->getMessage();
        $this->viewModel->errors = $response->getErrors();
        $this->viewModel->data = $response->getPosts();
    }

    /**
     * @return GetAllPostViewModel|null
     */
    public function getViewModel(): ?GetAllPostViewModel
    {
        return $this->viewModel;
    }

}