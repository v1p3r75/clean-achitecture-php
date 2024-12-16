<?php

namespace Presentation\User;

use Application\Presenter\ShowUserPresenter;
use Application\Response\UserResponse;
use Presentation\User\ViewModel\ShowUserViewModel;

class ShowUserJsonPresenter implements ShowUserPresenter
{

    private ?ShowUserViewModel $viewModel = null;

    public function present(UserResponse $response): void
    {
        $this->viewModel = new ShowUserViewModel();
        $this->viewModel->status = $response->getStatus();
        $this->viewModel->httpCode = $response->getHttpCode();
        $this->viewModel->message = $response->getMessage();
        $this->viewModel->errors = $response->getErrors();
        if ($response->getUser()) {
            $this->viewModel->data = [
                'id' => $response->getUser()->getId(),
                'email' => $response->getUser()->getEmail(),
                'username' => $response->getUser()->getUsername(),
                'isAdmin' => $response->getUser()->getIsAdmin(),
                'createdAt' => $response->getUser()->getCreatedAt()?->format("Y-m-d"),
            ];
        }
    }

    /**
     * @return ShowUserViewModel|null
     */
    public function getViewModel(): ?ShowUserViewModel
    {
        return $this->viewModel;
    }

}