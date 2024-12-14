<?php

namespace Domain\Service;

use Ramsey\Uuid\Uuid as UuidUuid;

class Uuid
{

    public static function get(): string
    {
        return UuidUuid::uuid7();
    }
}
