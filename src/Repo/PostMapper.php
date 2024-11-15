<?php // src/Repository/PostMapper.php

namespace App\Repo;

use App\Entity\Post;
use Doctrine\DBAL\Connection;
use followed\framed\Dbal\DataMapper;
use http\Env\Request;

class PostMapper
{
    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function save(Post $post , \followed\framed\Http\Request  $request): void
    {
        $stmt = $this->dataMapper->getConnection()->prepare("
            INSERT INTO posts (title, body, created_at)
            VALUES (:title, :body, :created_at) 
        ");

        $stmt->bindValue(':title', $post->getTitle());
        $stmt->bindValue(':body', $post->getBody());
        $stmt->bindValue(':created_at', $post->getCreatedAt()->format('Y-m-d H:i:s'));

        $stmt->executeStatement();
        $id = $this->dataMapper->save($post,$request);
        $post->setId($id);

    }
}



