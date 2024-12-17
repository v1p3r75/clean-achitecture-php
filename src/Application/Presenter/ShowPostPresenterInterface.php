<?php

namespace Application\Presenter;

use Application\Response\PostResponse;

interface ShowPostPresenterInterface
{
    public function present(PostResponse $response): void;

}