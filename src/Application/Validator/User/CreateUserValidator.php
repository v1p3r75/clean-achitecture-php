<?php

namespace Application\Validator\User;

use Application\Validator\BaseValidator;
use Assert\Assert;
use Assert\LazyAssertionException;

class CreateUserValidator extends BaseValidator
{

    public function validate($request): bool
    {
        try {

            Assert::lazy()
                ->that($request->email, 'email')->email()
                ->that($request->username, 'username')->minLength(4)
                ->that($request->password, 'password')->minLength(8)
                ->verifyNow();

            return true;

        } catch (LazyAssertionException $e) {

            $this->setErrors($e->getErrorExceptions());

            return false;
        }
    }

}