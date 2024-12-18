<?php

namespace Application\Validator\Comment;

use Application\Request\Comment\CreateCommentRequest;
use Application\Validator\BaseValidator;
use Assert\Assert;
use Assert\LazyAssertionException;

class CreateCommentValidator extends BaseValidator
{
    /**
     * @param CreateCommentRequest $request
     * @return bool
     */
    public function validate($request): bool
    {
        try {

            Assert::lazy()
                ->that($request->content, 'content')->string()
                ->that($request->userId, 'userId')->string()
                ->that($request->postId, 'postId')->string()
                ->verifyNow();

            return true;

        } catch (LazyAssertionException $e) {

            $this->setErrors($e->getErrorExceptions());

            return false;

        }
    }
}