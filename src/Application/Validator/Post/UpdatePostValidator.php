<?php

namespace Application\Validator\Post;

use Application\Validator\BaseValidator;
use Assert\Assert;
use Assert\LazyAssertionException;

class UpdatePostValidator extends BaseValidator
{

    public function validate($request): bool
    {
        try {

            Assert::lazy()
                ->that($request->id, 'id')->string()
                ->that($request->title, 'title')->nullOr()->string()->minLength(4)
                ->that($request->content, 'content')->nullOr()->string()->minLength(10)
                ->verifyNow();

            return true;

        } catch (LazyAssertionException $e) {

            $this->setErrors($e->getErrorExceptions());

            return false;

        }
    }
}