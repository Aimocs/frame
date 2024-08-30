<?php

namespace App\Repo;

use App\Entity\User;
use Doctrine\DBAL\Connection;
use followed\framed\Authentication\AuthRepositoryInterface;
use followed\framed\Authentication\AuthUserInterface;

class UserRepo implements AuthRepositoryInterface
{
    public function __construct(private Connection $connection)
    {

    }
    public function findByUsername(string $username):?AuthUserInterface
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('id', 'username', 'password', 'created_at')
            ->from('users')
            ->where('username = :username')
            ->setParameter('username', $username);

        $result = $queryBuilder->executeQuery();

        $row = $result->fetchAssociative();

        if (!$row) {
            return null;
        }

        $user = new User(
            id: $row['id'],
            username: $row['username'],
            password: $row['password'],
            createAt: new \DateTimeImmutable($row['created_at'])
        );

        return $user;
    }

}