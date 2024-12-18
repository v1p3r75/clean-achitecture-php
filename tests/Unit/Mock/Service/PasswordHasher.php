<?php

namespace Tests\Unit\Mock\Service;

use Application\Contract\PasswordHasherInterface;

class PasswordHasher implements PasswordHasherInterface
{

    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}