<?php

namespace App\Entity;

use followed\framed\Authentication\AuthUserInterface;

class User implements AuthUserInterface
{
    public function __construct(
        private ?int $id,
        private string $username,
        private string $password,
        private ?\DateTimeImmutable $createAt
    )
    {

    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getAuthId():int|string
    {
        return $this->id;
    }
    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public static function create(string $username,string $plainPassword):self
    {
        return new self(
            null,
            $username,
            password_hash($plainPassword,PASSWORD_DEFAULT),
            new \DateTimeImmutable()
        );
    }
}