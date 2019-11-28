<?php

namespace App\Service\Helper;


use App\Dto\User;
use App\Entity\User as UserEntity;

interface RegistrationInterface
{
    public function registry(User $dto): UserEntity;
}
