<?php

namespace App\EventListener;

use followed\framed\Dbal\Entity;
use followed\framed\Dbal\Event\PostPersist;


class SendEmail
{
    public function __invoke(PostPersist $postPersist)
    {
        $postPersist->getRequest()->getSession()->setFlash("email","email sent");
    }
}