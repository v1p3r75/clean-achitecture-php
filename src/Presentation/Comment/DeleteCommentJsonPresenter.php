<?php

namespace Presentation\Comment;

use Application\Presenter\DeleteCommentPresenterInterface;
use Application\Response\BaseResponse;
use Presentation\ViewModel\BaseViewModel;

class DeleteCommentJsonPresenter implements DeleteCommentPresenterInterface
{
    private ?BaseViewModel $viewModel = null;

    public function present(BaseResponse $response): void
    {
        $this->viewModel = new BaseViewModel();
        $this->viewModel->status = $response->getStatus();
        $this->viewModel->httpCode = $response->getHttpCode();
        $this->viewModel->message = $response->getMessage();
        $this->viewModel->errors = $response->getErrors();
    }

    /**
     * @return BaseViewModel|null
     */
    public function getViewModel(): ?BaseViewModel
    {
        return $this->viewModel;
    }
}