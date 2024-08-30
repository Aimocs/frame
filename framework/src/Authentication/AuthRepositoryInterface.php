<?php

namespace followed\framed\Authentication;

interface AuthRepositoryInterface
{
    public function findByUsername (string $username):?AuthUserInterface;
}