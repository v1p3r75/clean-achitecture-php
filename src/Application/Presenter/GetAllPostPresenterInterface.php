<?php

namespace Application\Presenter;

use Application\Response\GetAllPostResponse;

interface GetAllPostPresenterInterface
{
    public function present(GetAllPostResponse$response): void;

}