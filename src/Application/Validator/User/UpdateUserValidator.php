<?php

namespace Application\Validator\User;

use Application\Request\User\UpdateUserRequest;
use Application\Validator\BaseValidator;
use Assert\Assert;
use Assert\LazyAssertionException;

class UpdateUserValidator extends BaseValidator
{


    /**
     * @param UpdateUserRequest $request
     * @return bool
     */
    public function validate($request): bool
    {
        try {

            Assert::lazy()
                ->that($request->id, 'id')->string()
                ->that($request->email, 'email')->nullOr()->email()
                ->that($request->username, 'username')->nullOr()->minLength(4)
                ->that($request->password, 'password')->nullOr()->minLength(8)
                ->verifyNow();

            return true;

        } catch (LazyAssertionException $e) {

            $this->setErrors($e->getErrorExceptions());

            return false;
        }
    }

}