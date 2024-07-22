<?php
namespace App\Controller;
use followed\framed\Http\Response;

class PostController
{
    public function show(int $id){
        return new Response("this is post ".$id);
    }
}