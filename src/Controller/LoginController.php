<?php

namespace App\Controller;


use followed\framed\Authentication\SessionAuthentication;
use followed\framed\Controller\AbstractController;
use followed\framed\Http\RedirectResponse;
use followed\framed\Http\Response;

class LoginController extends  AbstractController
{
    public function __construct(private SessionAuthentication $authComponent)
    {
    }

    public function index(): Response
    {
        return $this->render('login.html.twig');
    }
    public function login():Response
    {
        $userIsAuthenticated = $this->authComponent->authenticate(
            $this->request->input("username"),
            $this->request->input("password")
        );
        if(!$userIsAuthenticated){
            $this->request->getSession()->setFlash('error','Bad Creds');
            return new RedirectResponse('/login');

        }
        $user = $this->authComponent->getUser();

        $this ->request->getSession()->setFlash("success","Logined In");
        return new RedirectResponse('/dash');
    }
}