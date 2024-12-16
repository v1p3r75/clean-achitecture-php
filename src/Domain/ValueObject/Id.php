<?php

namespace Domain\ValueObject;

use Ramsey\Uuid\Uuid;

class Id
{

    private string $value;

    public function __construct() {
        $this->value = Uuid::uuid7();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->getValue();
    }

}