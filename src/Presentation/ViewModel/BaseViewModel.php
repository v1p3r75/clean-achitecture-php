<?php

namespace Presentation\ViewModel;

class BaseViewModel
{
    public bool $status;

    public int $httpCode = 200;

    public string $message = '';

    public array $errors = [];

    public array $data = [];
}