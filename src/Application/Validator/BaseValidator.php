<?php

namespace Application\Validator;

use Application\Contract\ValidatorInterface;
use Assert\InvalidArgumentException;

abstract class BaseValidator implements ValidatorInterface
{

    protected array $errors = [];

    abstract public function validate($request): bool;

    public function getErrors(): array {

        return $this->errors;
    }

    /**
     * @param InvalidArgumentException[] $errors
     * @return void
     */
    protected function setErrors(array $errors): void {

        foreach ($errors as $error) {
            $this->errors[] = [$error->getPropertyPath(), $error->getMessage()];
        }
    }

}