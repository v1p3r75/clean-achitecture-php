<?php

namespace Presentation\Comment;

use Application\Presenter\GetAllCommentPresenterInterface;
use Application\Response\GetAllCommentResponse;
use Presentation\Comment\ViewModel\GetAllCommentViewModel;

class GetAllCommentJsonPresenter implements GetAllCommentPresenterInterface
{

    private ?GetAllCommentViewModel $viewModel = null;

    public function present(GetAllCommentResponse $response): void
    {
        $this->viewModel = new GetAllCommentViewModel();
        $this->viewModel->status = $response->getStatus();
        $this->viewModel->httpCode = $response->getHttpCode();
        $this->viewModel->message = $response->getMessage();
        $this->viewModel->errors = $response->getErrors();
        $this->viewModel->data = $response->getComments();
    }

    /**
     * @return GetAllCommentViewModel|null
     */
    public function getViewModel(): ?GetAllCommentViewModel
    {
        return $this->viewModel;
    }

}