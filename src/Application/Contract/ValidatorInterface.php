<?php

namespace Application\Contract;

interface ValidatorInterface
{

    public function validate($request): bool;

    public function getErrors(): array;

}