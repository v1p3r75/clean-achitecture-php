<?php

namespace Domain\Contracts;

interface UserRepositoryInterface
{
    public function save();

    public function find();

    public function findAll();
}
