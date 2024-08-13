<?php
namespace App\Controller;
use followed\framed\Http\Response;
use followed\framed\Controller\AbstractController;
class PostController extends AbstractController
{
    public function show(int $id):Response{
        return $this->render('post.html.twig',[
            'id'=>$id
        ]);
    }
    public function create():Response
    {
        return $this->render('create_post.html.twig');
    }
}