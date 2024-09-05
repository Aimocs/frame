<?php

namespace followed\framed\Authentication;

use followed\framed\Session\Session;
use followed\framed\Session\SessionInterface;

class SessionAuthentication implements  SessionAuthInterface
{
    private AuthUserInterface $user;
    public function __construct(private AuthRepositoryInterface $authRepository, private SessionInterface $session)
    {

    }
    public function authenticate(string $username, string $password): bool
    {
        $user = $this->authRepository->findByUsername($username);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        $this->login($user);
        return true;
    }

    public function login(AuthUserInterface $user)
    {
        // Start a session
        $this->session->start();
        // Log the user in
        $this->session->set(Session::AUTH_KEY,$user->getAuthId());
        // Set the user
        $this->user = $user;
    }

    public function logout()
    {
        $this->session->remove(Session::AUTH_KEY);
    }

    public function getUser(): AuthUserInterface
    {
        return $this->user;
    }

}