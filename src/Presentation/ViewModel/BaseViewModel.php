<?php

namespace Presentation\ViewModel;

abstract class BaseViewModel
{
    public bool $status;

    public int $httpCode;

    public string $message;

    public array $errors;

}