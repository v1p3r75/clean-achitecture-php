<?php

namespace Presentation\User;

use Application\Presenter\GetAllUserPresenterInterface;
use Application\Response\GetAllUserResponse;
use Presentation\User\ViewModel\GetAllUserViewModel;

class GetAllUserJsonPresenter implements GetAllUserPresenterInterface
{

    private ?GetAllUserViewModel $viewModel = null;

    public function present(GetAllUserResponse $response): void
    {
        $this->viewModel = new GetAllUserViewModel();
        $this->viewModel->status = $response->getStatus();
        $this->viewModel->httpCode = $response->getHttpCode();
        $this->viewModel->message = $response->getMessage();
        $this->viewModel->errors = $response->getErrors();
        $this->viewModel->data = $response->getUsers();
    }

    /**
     * @return GetAllUserViewModel|null
     */
    public function getViewModel(): ?GetAllUserViewModel
    {
        return $this->viewModel;
    }

}