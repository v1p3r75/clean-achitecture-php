<?php

namespace Application\Response;

class BaseResponse
{

    protected bool $status = true;

    protected int $httpCode = 200;

    protected string $message = "";

    protected array $errors = [];

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function setHttpCode(int $code): void
    {
        $this->httpCode = $code;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function addError(string $field, string|array $message): void
    {
        $this->errors[$field] = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}