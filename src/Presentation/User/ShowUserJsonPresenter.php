<?php

namespace Presentation\User;

use Application\Presenter\ShowUserPresenterInterface;
use Application\Response\UserResponse;
use Presentation\User\ViewModel\ShowUserViewModel;

class ShowUserJsonPresenter implements ShowUserPresenterInterface
{

    private ?ShowUserViewModel $viewModel = null;

    public function present(UserResponse $response): void
    {
        $this->viewModel = new ShowUserViewModel();
        $this->viewModel->status = $response->getStatus();
        $this->viewModel->httpCode = $response->getHttpCode();
        $this->viewModel->message = $response->getMessage();
        $this->viewModel->errors = $response->getErrors();
        if ($user = $response->getUser()) {
            $this->viewModel->data = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'isAdmin' => $user->getIsAdmin(),
                'createdAt' => $user->getCreatedAt()?->format("Y-m-d"),
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