<?php

namespace Application\Validator\Comment;

use Application\Request\Comment\UpdateCommentRequest;
use Application\Validator\BaseValidator;
use Assert\Assert;
use Assert\LazyAssertionException;

class UpdateCommentValidator extends BaseValidator
{
    /**
     * @param UpdateCommentRequest $request
     * @return bool
     */
    public function validate($request): bool
    {
        try {

            Assert::lazy()
                ->that($request->id, 'id')->string()
                ->that($request->content, 'content')->nullOr()->string()
                ->verifyNow();

            return true;

        } catch (LazyAssertionException $e) {

            $this->setErrors($e->getErrorExceptions());

            return false;

        }
    }
}