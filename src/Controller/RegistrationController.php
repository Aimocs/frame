<?php

namespace App\Controller;

use App\Form\User\RegistrationForm;
use App\Repo\UserMapper;
use followed\framed\Authentication\SessionAuthentication;
use followed\framed\Controller\AbstractController;
use followed\framed\Http\RedirectResponse;
use followed\framed\Http\Response;

class RegistrationController extends AbstractController
{
    public function __construct(private UserMapper $userMapper ,private  SessionAuthentication $authComponent)
    {

    }
    public function index():Response
    {
        return $this->render("register.html.twig");
    }

    public function register():Response
    {
        $form = new RegistrationForm($this->userMapper);
        $form->setFields(
            $this->request->input('username'),
            $this->request->input('password')
        );
        if($form->hasValidationErrors()){
            foreach($form->getValidationErrors() as $error)
            {
                $this->request->getSession()->setFlash('error',$error);
            }
            return new RedirectResponse('/register');
        }
        $user = $form->save();

        $this->request->getSession()->setFlash("success","User Created!!");
        $this->authComponent->login($user);
        return (new RedirectResponse('/dash'));
    }
}