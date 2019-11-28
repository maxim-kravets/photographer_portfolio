<?php

namespace App\Dto;


final class User
{
    private $username;
    private $email;
    private $password;
    private $retype_password;
    private $is_admin;

    public function __construct(
        string $username,
        string $email,
        string $password,
        string $retype_password,
        bool $is_admin = false
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->retype_password = $retype_password;
        $this->is_admin = $is_admin;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRetypePassword(): string
    {
        return $this->retype_password;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

}
