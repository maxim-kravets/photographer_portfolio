<?php

namespace App\Service\Helper;


use App\Dto\User;
use App\Entity\User as UserEntity;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Registration implements RegistrationInterface
{
    private $userRepository;
    private $passwordEncoder;

    public function __construct(UserRepositoryInterface $userRepository, UserPasswordEncoderInterface $passwordEncoder) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function registry(User $dto): UserEntity
    {
        $entity = UserEntity::create($dto);
        $entity->setPassword($this->passwordEncoder->encodePassword($entity, $dto->getPassword()));
        $this->userRepository->save($entity);

        return $entity;
    }
}
