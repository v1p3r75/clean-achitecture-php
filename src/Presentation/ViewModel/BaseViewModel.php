<?php

namespace Presentation\ViewModel;

abstract class BaseViewModel
{
    public bool $status;

    public int $httpCode = 200;

    public string $message = '';

    public array $errors = [];

}