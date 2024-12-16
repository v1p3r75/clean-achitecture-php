<?php

namespace Application\Response;

use Domain\Entity\User;

class GetAllUserResponse extends BaseResponse
{

    /**
     * @var User[]
     */
    private array $users = [];

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param User[] $users
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;
    }
}