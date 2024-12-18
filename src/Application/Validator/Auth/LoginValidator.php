<?php

namespace Application\Validator\Auth;


use Application\Request\Auth\LoginRequest;
use Application\Validator\BaseValidator;
use Assert\Assert;
use Assert\LazyAssertionException;

class LoginValidator extends BaseValidator
{
    /**
     * @param LoginRequest $request
     * @return bool
     */
    public function validate($request): bool
    {
        try {

            Assert::lazy()
                ->that($request->email, 'email')->email()
                ->that($request->password, 'password')->string()
                ->verifyNow();

            return true;

        } catch (LazyAssertionException $e) {

            $this->setErrors($e->getErrorExceptions());

            return false;

        }
    }
}