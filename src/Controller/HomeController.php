<?php
namespace App\Controller;
use followed\framed\Http\Response;

class HomeController
{
    public  function index():Response
    {
        return new Response("INDEX FUN",201);
    }
}