<?php
namespace App\Controller;
use followed\framed\Http\Response;
use followed\framed\Routing\Router;
use App\test;
use followed\framed\Controller\AbstractController;
class HomeController extends AbstractController
{
    public function __construct(private test $test)
    {

    }
    public  function index():Response
    {
        
        return $this->render('home.html.twig');
    }
}