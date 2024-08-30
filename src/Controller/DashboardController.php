<?php

namespace App\Controller;

use followed\framed\Controller\AbstractController;
use followed\framed\Http\Response;

class DashboardController extends AbstractController
{
    public function index():Response
    {
        return $this->render('dash.html.twig');
    }

}