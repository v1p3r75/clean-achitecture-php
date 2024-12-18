<?php

namespace Presentation\Comment;

use Application\Presenter\ShowCommentPresenterInterface;
use Application\Response\CommentResponse;
use Presentation\Comment\ViewModel\ShowCommentViewModel;

class ShowCommentJsonPresenter implements ShowCommentPresenterInterface
{

    private ?ShowCommentViewModel $viewModel = null;

    public function present(CommentResponse $response): void
    {
        $this->viewModel = new ShowCommentViewModel();
        $this->viewModel->status = $response->getStatus();
        $this->viewModel->httpCode = $response->getHttpCode();
        $this->viewModel->message = $response->getMessage();
        $this->viewModel->errors = $response->getErrors();
        if ($comment = $response->getComment()) {
            $this->viewModel->data = [
                'id' => $comment->getId(),
                'content' => $comment->getContent(),
                'post' => [
                    'id' => $comment->getPost()->getId(),
                    'title' => $comment->getPost()->getTitle(),
                    'content' => $comment->getPost()->getContent(),
                ],
                'user' => [
                    'id' => $comment->getUser()->getId(),
                    'username' => $comment->getUser()->getUsername()
                ],
                'createdAt' => $comment->getCreatedAt()?->format("Y-m-d"),
            ];
        }
    }

    /**
     * @return ShowCommentViewModel|null
     */
    public function getViewModel(): ?ShowCommentViewModel
    {
        return $this->viewModel;
    }

}